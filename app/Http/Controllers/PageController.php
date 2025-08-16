<?php

namespace App\Http\Controllers;

use App\Models\BondPrice;
use App\Models\EtfPrice;
use App\Models\NsePrice;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view('pages.index');
    }
    public function about()
    {
        return view('pages.about');
    }

    public function team()
    {
        return view('pages.team');
    }

    public function services()
    {
        return view('pages.services');
    }

    public function contact()
    {
        return view('pages.contact');
    }

 public function nse()
{
    $nsePrices = NsePrice::orderByRaw("CASE WHEN LOWER(security_name) = 'total' THEN 1 ELSE 0 END")
        ->orderBy('security_name', 'asc')
        ->paginate(20);

    return view('pages.nse', compact('nsePrices'));
}


    public function ETF()
    {
        $EtfPrice = EtfPrice::orderBy('security_name', 'asc')->paginate(20);
        return view('pages.etf', [
            'etfPrices' => $EtfPrice
        ]);
    }

    public function bonds()
    {
        $bondPrice = BondPrice::orderBy('security_name', 'asc')->paginate(20);
        return view('pages.bonds', [
            'bondPrices' => $bondPrice
        ]);
    }
}
