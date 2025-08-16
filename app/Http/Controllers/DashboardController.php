<?php

namespace App\Http\Controllers;

use App\Models\EtfPrice;
use App\Models\NsePrice;
use App\Models\BondPrice;
use App\Models\GainerETF;
use App\Models\LoserDebt;
use App\Models\TopGainer;
use App\Models\LoserEquity;
use Illuminate\Support\Str;
use App\Models\GainerEquity;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $nsePrices = NsePrice::orderByRaw("CASE WHEN LOWER(security_name) = 'total' THEN 1 ELSE 0 END")
            ->orderBy('security_name', 'asc')
            ->paginate(10);
        $totalCustomers = NsePrice::count();

        return view('dashboard.index', compact('nsePrices', 'totalCustomers'));
    }


    public function adminNse()
    {
        $nsePrices = NsePrice::orderByRaw("CASE WHEN LOWER(security_name) = 'total' THEN 1 ELSE 0 END")
            ->orderBy('security_name', 'asc')
            ->paginate(3);

        return view('dashboard.nse', [
            'nsePrices' => $nsePrices,
        ]);
    }


    public function extractPricing(Request $request)
    {
        $request->validate([
            'nse' => ['required'],
        ]);

        // 1) Temp store
        $path = $request->file('nse')->store('tmp');
        $fullPath = Storage::path($path);

        // 2) Load workbook
        try {
            $spreadsheet = IOFactory::load($fullPath);
        } catch (\Throwable $e) {
            Storage::delete($path);
            return response()->json([
                'ok' => false,
                'error' => 'Failed to read spreadsheet: ' . $e->getMessage(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // 3) Parse every worksheet and merge buckets
        $combined = ['NSE' => [], 'ETF' => [], 'BOND' => []];
        foreach ($spreadsheet->getAllSheets() as $ws) {
            [$nseRows, $etfRows, $bondRows] = $this->splitByCategory($ws);
            $combined = $this->mergeBuckets($combined, [
                'NSE' => $nseRows,
                'ETF' => $etfRows,
                'BOND' => $bondRows,
            ]);
        }

        // 4) Resolve trade date
        $firstSheet = $spreadsheet->getSheet(0);
        $tradeDate = $this->resolveTradeDate($request->input('date'), $firstSheet); // 'Y-m-d' or null

        // 5) Insert (upsert) into DB
// 5) Delete existing rows, then insert (upsert) new ones
        $this->wipePriceTables(); // <— delete everything first
        [$nseCount, $etfCount, $bondCount] = $this->persistBuckets($combined, $tradeDate);

        // 6) Cleanup + log
        Storage::delete($path);

        Log::info('Pricing extraction completed', [
            'ok' => true,
            'tradeDate' => $tradeDate,
            'inserted' => [
                'NSE' => $nseCount,
                'ETF' => $etfCount,
                'BOND' => $bondCount
            ],
        ]);

        return back()->with('success', 'Pricing data extracted successfully');

    }

    private function wipePriceTables(): void
    {

        DB::table((new NsePrice)->getTable())->delete();
        DB::table((new EtfPrice)->getTable())->delete();
        DB::table((new BondPrice)->getTable())->delete();
    }


    /** Merge two bucket sets: keep the first header we see and append data rows. */
    private function mergeBuckets(array $base, array $add): array
    {
        foreach (['NSE', 'ETF', 'BOND'] as $c) {
            if (empty($add[$c]))
                continue;

            if (empty($base[$c])) {
                $base[$c] = $add[$c];
                continue;
            }
            // Replace "Note" placeholder with actual header+rows
            if (isset($base[$c][0]['Note'])) {
                $base[$c] = $add[$c];
                continue;
            }
            // If both have real headers, append add's data rows
            if (!isset($add[$c][0]['Note'])) {
                $base[$c] = array_merge($base[$c], array_slice($add[$c], 1));
            }
        }
        return $base;
    }

    /** Split one worksheet into NSE / ETF / BOND buckets. (Robust to merged cells) */
    private function splitByCategory(Worksheet $sheet): array
    {
        $rows = $sheet->toArray(null, true, true, true); // A,B,C... keys
        $current = null;

        $buckets = ['NSE' => [], 'ETF' => [], 'BOND' => []];
        $headerCaptured = ['NSE' => false, 'ETF' => false, 'BOND' => false];

        foreach ($rows as $row) {
            // Combine whole row text to detect section headers reliably
            $line = trim(implode(' ', array_map(
                fn($v) => trim((string) $v),
                array_values($row)
            )));
            $line = preg_replace('/\s+/', ' ', $line); // normalize spaces

            if ($cat = $this->detectCategory($line)) {
                $current = $cat;
                continue; // next non-empty structured row becomes header
            }

            if ($current === null)
                continue;

            // First structured row after the section header becomes the table header
            if (!$headerCaptured[$current]) {
                if ($this->looksLikeHeader($row)) {
                    $buckets[$current][] = $this->normalizeRow($row);
                    $headerCaptured[$current] = true;
                }
                continue;
            }

            // Append data rows (skip fully blank)
            if (!$this->isBlankRow($row)) {
                $buckets[$current][] = $this->normalizeRow($row);
            }
        }

        // Ensure each bucket has header or a note
        foreach (['NSE', 'ETF', 'BOND'] as $c) {
            if (empty($buckets[$c])) {
                $buckets[$c][] = ['Note' => "No rows detected for {$c}"];
            }
        }

        return [$buckets['NSE'], $buckets['ETF'], $buckets['BOND']];
    }

    /** Identify the section by the full line text. */
    private function detectCategory(?string $line): ?string
    {
        if (!$line)
            return null;

        $t = strtoupper(trim($line));
        $t = preg_replace('/\s+/', ' ', $t);

        if (preg_match('~PRICES FOR\s+EQUITY\s+SECURITIES\s+TRADED ON~i', $t))
            return 'NSE';
        if (preg_match('~PRICES FOR\s+ETF\s+SECURITIES\s+TRADED ON~i', $t))
            return 'ETF';
        if (preg_match('~PRICES FOR\s+BOND\s+SECURITIES\s+TRADED ON~i', $t))
            return 'BOND';

        // loose variants
        if (preg_match('~\bPRICES FOR\b.*\bEQUITY\b.*\bTRADED ON\b~i', $t))
            return 'NSE';
        if (preg_match('~\bPRICES FOR\b.*\bETF\b.*\bTRADED ON\b~i', $t))
            return 'ETF';
        if (preg_match('~\bPRICES FOR\b.*\bBOND\b.*\bTRADED ON\b~i', $t))
            return 'BOND';

        return null;
    }

    /** Header heuristic: at least 2 non-empty cells among A..H. */
    private function looksLikeHeader(array $row): bool
    {
        $keys = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
        $nonEmpty = 0;
        foreach ($keys as $k) {
            if (isset($row[$k]) && trim((string) $row[$k]) !== '')
                $nonEmpty++;
        }
        return $nonEmpty >= 2;
    }

    /** True if every cell is empty/whitespace. */
    private function isBlankRow(array $row): bool
    {
        foreach ($row as $cell) {
            if (trim((string) $cell) !== '')
                return false;
        }
        return true;
    }

    /** Convert a letter-keyed row to a trimmed numeric-indexed array (drop trailing blanks). */
    private function normalizeRow(array $row): array
    {
        if (is_array($row) && array_key_exists('Note', $row) && count($row) === 1) {
            return $row; // synthetic note row
        }
        $vals = [];
        foreach ($row as $letter => $val) {
            $vals[] = is_null($val) ? '' : trim((string) $val);
        }
        for ($i = count($vals) - 1; $i >= 0; $i--) {
            if ($vals[$i] === '')
                unset($vals[$i]);
            else
                break;
        }
        return array_values($vals);
    }

    /** Insert all buckets into DB using upsert; return [nseCount, etfCount, bondCount]. */
    private function persistBuckets(array $buckets, ?string $tradeDate): array
    {
        $counts = ['NSE' => 0, 'ETF' => 0, 'BOND' => 0];

        foreach ($buckets as $name => $rows) {
            if (empty($rows) || count($rows) < 2)
                continue; // need header + at least one data row
            $header = $rows[0];
            if (isset($header['Note']))
                continue;

            // Normalize header -> keys (snake_case)
            $keys = $this->normalizeHeaderToKeys($header);

            // Build records
            $toInsert = [];
            foreach (array_slice($rows, 1) as $r) {
                if (isset($r['Note']))
                    continue;
                $rec = $this->rowToAssoc($keys, $r);
                $mapped = $this->mapToDbColumns($rec, $tradeDate);
                if (!$mapped)
                    continue;
                $toInsert[] = $mapped;
            }

            if (empty($toInsert))
                continue;

            // Unique key: prefer (trade_date, symbol); fallback (trade_date, security_name)
            $hasSymbol = collect($toInsert)->contains(fn($x) => !empty($x['symbol']));
            $uniqueBy = $hasSymbol ? ['trade_date', 'symbol'] : ['trade_date', 'security_name'];

            if ($name === 'NSE') {
                $this->chunkedUpsert(NsePrice::class, $toInsert, $uniqueBy);
                $counts['NSE'] += count($toInsert);
            } elseif ($name === 'ETF') {
                $this->chunkedUpsert(EtfPrice::class, $toInsert, $uniqueBy);
                $counts['ETF'] += count($toInsert);
            } elseif ($name === 'BOND') {
                $this->chunkedUpsert(BondPrice::class, $toInsert, $uniqueBy);
                $counts['BOND'] += count($toInsert);
            }
        }

        return [$counts['NSE'], $counts['ETF'], $counts['BOND']];
    }

    /** Header -> keys (snake_case, lowercase). */
    private function normalizeHeaderToKeys(array $header): array
    {
        $keys = [];
        foreach ($header as $i => $h) {
            $h = trim((string) $h);
            if ($h === '')
                $h = "col_" . ($i + 1);
            $h = preg_replace('/\(.+?\)/', '', $h); // drop things like (₦) or (%)
            $h = Str::slug($h, '_');                // "Previous Close" -> "previous_close"
            $h = preg_replace('/_+/', '_', $h);
            $keys[] = strtolower($h);
        }
        return $keys;
    }

    /** Combine header keys + row values into assoc array */
    private function rowToAssoc(array $keys, array $row): array
    {
        $vals = array_values($row);
        $assoc = [];
        for ($i = 0; $i < count($keys); $i++) {
            $assoc[$keys[$i]] = $vals[$i] ?? null;
        }
        return $assoc;
    }

    /**
     * Flexible mapping from arbitrary column names -> DB columns.
     * Extra/unmapped columns are stored in payload (JSON).
     */
    private function mapToDbColumns(array $rec, ?string $tradeDate): ?array
    {
        // Aliases (added spread_pct mapping)
        $aliases = [
            'symbol' => ['symbol', 'ticker', 'code', 'isin'],
            'security_name' => ['name', 'security', 'company', 'instrument', 'issue', 'security_name', 'description'],
            'open' => ['open', 'opening_price', 'opening'],
            'high' => ['high', 'day_high', 'highest'],
            'low' => ['low', 'day_low', 'lowest'],
            'close' => ['close', 'closing', 'closing_price', 'price', 'last', 'last_price', 'nav', 'mid', 'unit_price', 'bid', 'offer'],
            'previous_close' => ['previous_close', 'prev_close', 'prev', 'yesterday_close', 'pclose', 'prev_nav', 'previous_price'],
            'change' => ['change', 'price_change', 'chg'],
            'change_pct' => ['change_%', 'change_pct', '%change', 'percent_change', 'pct_change'],
            'spread_pct' => ['%spread', 'spread_%', 'spread%', 'spread', 'spread_pct', 'percent_spread', 'spread_percent', 'spread_(%)'],
            'volume' => ['volume', 'vol', 'units', 'unit_traded', 'units_traded'],
            'value' => ['value', 'turnover', 'turnover_value', 'traded_value', 'consideration'],
            'deals' => ['deals', 'trades', 'no_of_trades', 'no_trades'],
            'trade_date' => ['date', 'trade_date', 'traded_on', 'valuation_date'],
        ];

        $out = [
            'trade_date' => $tradeDate,
            'symbol' => null,
            'security_name' => null,
            'open' => null,
            'high' => null,
            'low' => null,
            'close' => null,
            'previous_close' => null,
            'change' => null,
            'change_pct' => null,
            'spread_pct' => null, // NEW
            'volume' => null,
            'value' => null,
            'deals' => null,
            'payload' => [],
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // helper: get by alias
        $get = function (string $field) use ($aliases, $rec) {
            foreach ($aliases[$field] as $alias) {
                if (array_key_exists($alias, $rec))
                    return $rec[$alias];
                $noUnderscoreAlias = str_replace('_', '', $alias);
                foreach ($rec as $k => $v) {
                    if (
                        strtolower($k) === strtolower($alias) ||
                        strtolower(str_replace('_', '', $k)) === strtolower($noUnderscoreAlias)
                    ) {
                        return $v;
                    }
                }
            }
            return null;
        };

        $out['symbol'] = $this->toSymbol($get('symbol'));
        $out['security_name'] = $this->toString($get('security_name'));
        $out['open'] = $this->toDecimal($get('open'));
        $out['high'] = $this->toDecimal($get('high'));
        $out['low'] = $this->toDecimal($get('low'));
        $out['close'] = $this->toDecimal($get('close'));
        $out['previous_close'] = $this->toDecimal($get('previous_close'));
        $out['change'] = $this->toDecimal($get('change'));
        $out['change_pct'] = $this->toPercent($get('change_pct'));
        $out['spread_pct'] = $this->toPercent($get('spread_pct')); // NEW
        $out['volume'] = $this->toInt($get('volume'));
        $out['value'] = $this->toDecimal($get('value'));
        $out['deals'] = $this->toInt($get('deals'));

        // Row-level date wins
        if ($rowDate = $this->parseDateLoose($get('trade_date'))) {
            $out['trade_date'] = $rowDate;
        }

        // Payload: unmapped columns
        $mappedKeys = collect($aliases)->flatten()->unique()->all();
        foreach ($rec as $k => $v) {
            if (!in_array($k, $mappedKeys, true)) {
                $out['payload'][$k] = is_scalar($v) ? trim((string) $v) : $v;
            }
        }

        // Accept if we have at least a name or a price (ETFs/Bonds might not have symbols)
        if (!$out['symbol'] && !$out['security_name'] && is_null($out['close'])) {
            return null;
        }
        return $out;
    }

    /** Upsert in chunks (encode payload for JSON columns). */
    private function chunkedUpsert(string $modelClass, array $rows, array $uniqueBy): void
    {
        foreach (array_chunk($rows, 1000) as $chunk) {
            foreach ($chunk as &$row) {
                // payload -> JSON string (upsert bypasses Eloquent casts)
                if (array_key_exists('payload', $row)) {
                    $row['payload'] = is_array($row['payload'])
                        ? json_encode($row['payload'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
                        : (is_string($row['payload']) ? $row['payload'] : null);
                }
                // empty strings → null for numerics
                foreach (['open', 'high', 'low', 'close', 'previous_close', 'change', 'change_pct', 'spread_pct', 'value'] as $dec) {
                    if (array_key_exists($dec, $row) && $row[$dec] === '')
                        $row[$dec] = null;
                }
                foreach (['volume', 'deals'] as $int) {
                    if (array_key_exists($int, $row) && $row[$int] === '')
                        $row[$int] = null;
                }
                // ensure dates/timestamps are strings
                if (isset($row['trade_date']) && $row['trade_date'] instanceof \DateTimeInterface) {
                    $row['trade_date'] = $row['trade_date']->format('Y-m-d');
                }
                if (isset($row['created_at']) && $row['created_at'] instanceof \DateTimeInterface) {
                    $row['created_at'] = $row['created_at']->format('Y-m-d H:i:s');
                }
                if (isset($row['updated_at']) && $row['updated_at'] instanceof \DateTimeInterface) {
                    $row['updated_at'] = $row['updated_at']->format('Y-m-d H:i:s');
                }
            }
            unset($row);

            $modelClass::upsert(
                $chunk,
                $uniqueBy, // e.g. ['trade_date','symbol'] or ['trade_date','security_name']
                [
                    'security_name',
                    'open',
                    'high',
                    'low',
                    'close',
                    'previous_close',
                    'change',
                    'change_pct',
                    'spread_pct',
                    'volume',
                    'value',
                    'deals',
                    'payload',
                    'updated_at'
                ]
            );
        }
    }

    /** Resolve trade date from request or header lines like "... TRADED ON 15/08/2025 ...". */
    private function resolveTradeDate(?string $input, Worksheet $sheet): ?string
    {
        if ($d = $this->parseDateLoose($input))
            return $d;

        $rows = $sheet->toArray(null, true, true, true);
        $limit = min(50, count($rows));
        for ($i = 1; $i <= $limit; $i++) {
            $a = isset($rows[$i]['A']) ? (string) $rows[$i]['A'] : '';
            $line = trim(implode(' ', array_map(fn($v) => trim((string) $v), array_values($rows[$i]))));
            if (
                stripos($a, 'TRADED ON') !== false || stripos($line, 'TRADED ON') !== false ||
                preg_match('~\b\d{1,2}[/\-]\d{1,2}[/\-]\d{2,4}\b~', $line)
            ) {
                if ($d = $this->parseDateLoose($line))
                    return $d;
            }
        }
        return null;
    }

    // ------------ value cleaners ------------
    private function toString($v): ?string
    {
        $s = trim((string) ($v ?? ''));
        return $s === '' ? null : $s;
    }

    private function toSymbol($v): ?string
    {
        $s = $this->toString($v);
        if ($s === null)
            return null;
        return strtoupper(preg_replace('/\s+/', '', $s));
    }

    private function toDecimal($v): ?string
    {
        if ($v === null || $v === '')
            return null;
        $s = strtoupper(trim((string) $v));
        $s = preg_replace('/[,%\s₦$€£]/', '', $s);
        if ($s === '' || !is_numeric($s))
            return null;
        return number_format((float) $s, 4, '.', '');
    }

    private function toPercent($v): ?string
    {
        if ($v === null || $v === '')
            return null;
        $s = str_replace(['%', ' '], '', (string) $v);
        if ($s === '' || !is_numeric($s))
            return null;
        return number_format((float) $s, 4, '.', '');
    }

    private function toInt($v): ?int
    {
        if ($v === null || $v === '')
            return null;
        $s = preg_replace('/[^\d]/', '', (string) $v);
        return $s === '' ? null : (int) $s;
    }

    private function parseDateLoose($v): ?string
    {
        if (!$v)
            return null;
        $s = strtoupper((string) $v);
        if (preg_match('~(\d{1,2})[/-](\d{1,2})[/-](\d{2,4})~', $s, $m)) {
            $d = (int) $m[1];
            $M = (int) $m[2];
            $y = (int) $m[3];
            if ($y < 100)
                $y += 2000;
            return sprintf('%04d-%02d-%02d', $y, $M, $d);
        }
        if (preg_match('~(\d{4})-(\d{1,2})-(\d{1,2})~', $s, $m)) {
            return sprintf('%04d-%02d-%02d', $m[1], $m[2], $m[3]);
        }
        return null;
    }
}
