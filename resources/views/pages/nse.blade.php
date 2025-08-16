@extends('layouts.app')
@section('main_content')
    <style>
        .nse-table-wrapper {
            padding: 40px 15px;
            background: #f9f9f9;
        }

        .nse-container {
            max-width: 1100px;
            margin: auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            /* removes the scrollbar */
        }

        .nse-table {
            width: 100%;
            border-collapse: collapse;
        }

        .nse-table th {
            background: #111;
            color: #ffa500;
            /* Pilot orange */
            padding: 14px 10px;
            font-weight: 600;
            text-align: left;
            font-size: 14px;
        }

        .nse-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 14px;
            color: #333;
        }

        .nse-table tbody tr:hover {
            background: #f5f5f5;
            transition: background 0.3s;
        }

        .nse-table .positive {
            color: green;
            font-weight: 600;
        }

        .nse-table .negative {
            color: red;
            font-weight: 600;
        }

        /* Pagination styling */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px;
            font-size: 14px;
        }

        .pagination-buttons a,
        .pagination-buttons span {
            padding: 8px 16px;
            border-radius: 5px;
            transition: background 0.3s;
            font-weight: 500;
            text-decoration: none;
        }

        .pagination-buttons a {
            background: #ffa500;
            color: #fff;
        }

        .pagination-buttons a:hover {
            background: #e59400;
        }

        .pagination-buttons .disabled {
            background: #ddd;
            color: #888;
            cursor: not-allowed;
        }

        /* Mobile adjustments */
        @media (max-width: 768px) {
            .nse-container {
                overflow-x: auto;
            }

            .nse-table th,
            .nse-table td {
                font-size: 13px;
                padding: 10px 8px;
            }

            .pagination-container {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
    </style>




    <br /><br />
    <section class="page-title centred" style="background-image: url(assets/images/background/page-title.jpg); top: -55px;">
        <div class="auto-container">
            <div class="content-box clearfix">
                <h1>NSE Price List</h1>
                <ul class="bread-crumb clearfix">
                    <li><a href="/">Home</a></li>
                    <li>NSE Price List</li>
                </ul>
            </div>
        </div>
    </section>





    <section class="nse-table-wrapper">
  <div class="nse-container">

    <div class="nse-table-scroll">
      <table class="nse-table">
        <thead>
          <tr>
            <th>Company</th>
            <th>Previous Close</th>
            <th>Open</th>
            <th>High</th>
            <th>Low</th>
            <th>%Spread</th>
            <th>Close</th>
            <th>%Change</th>
            <th>Trades</th>
            <th>Volume</th>
            <th>Value</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($nsePrices as $item)
            <tr>
              <td>{{ $item->security_name }}</td>
              <td>{{ $item->previous_close ?? '-' }}</td>
              <td>{{ $item->open ?? '-' }}</td>
              <td>{{ $item->high ?? '-' }}</td>
              <td>{{ $item->low ?? '-' }}</td>
              <td>{{ $item->spread_pct ?? '-' }}</td>
              <td>{{ $item->close ?? '-' }}</td>
              <td class="{{ $item->change > 0 ? 'positive' : ($item->change < 0 ? 'negative' : '') }}">
                {{ $item->change ?? '-' }}
              </td>
              <td>{{ $item->deals ?? '-' }}</td>
              <td>{{ $item->volume !== null ? number_format($item->volume) : '-' }}</td>
              <td>{{ $item->value !== null ? number_format($item->value, 2) : '-' }}</td>
              <td>{{ $item->trade_date ? \Carbon\Carbon::parse($item->trade_date)->format('d-m-Y') : '-' }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="12" class="text-center">No price data available.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Pagination (bottom-sticky inside container) --}}
    <div class="pagination-container">
      <div class="pagination-total">
        Showing
        <span class="font-semibold">
          {{ ($nsePrices->currentPage() - 1) * $nsePrices->perPage() + 1 }}
        </span>
        to
        <span class="font-semibold">
          {{ ($nsePrices->currentPage() - 1) * $nsePrices->perPage() + $nsePrices->count() }}
        </span>
        of
        <span class="font-semibold">
          {{ $nsePrices->total() }}
        </span>
        results
      </div>

      <div class="pagination-buttons">
        @if ($nsePrices->onFirstPage())
          <span class="disabled">Previous</span>
        @else
          <a href="{{ $nsePrices->previousPageUrl() }}">Previous</a>
        @endif

        @if ($nsePrices->hasMorePages())
          <a href="{{ $nsePrices->nextPageUrl() }}">Next</a>
        @else
          <span class="disabled">Next</span>
        @endif
      </div>
    </div>

  </div>
</section>

@endsection
