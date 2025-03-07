<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockTransaction;

class InTodayController extends Controller
{
    public function index()
    {
        $lowproducts = Product::whereColumn('stock', '<', 'minimum_stock')->get();
        $intodays = StockTransaction::whereIn('type', ['Masuk'])->whereIn('status',['Diterima'])->whereDate('date',now())->get();
        $outtodays = StockTransaction::whereIn('type', ['Keluar'])->whereIn('status',['Dikeluarkan'])->whereDate('date',now())->get();

        return view('manager.dashboard.intoday.index',compact('lowproducts','intodays','outtodays'));
    }
}