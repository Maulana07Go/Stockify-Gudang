<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockTransaction;

class ManagerController extends Controller
{
    public function index()
    {
        $totallowproducts = Product::whereColumn('stock', '<', 'minimum_stock')->count();
        $intoday = StockTransaction::whereIn('type', ['Masuk'])->whereIn('status',['Diterima'])->whereDate('date',now())->count();
        $outtoday = StockTransaction::whereIn('type', ['Keluar'])->whereIn('status',['Dikeluarkan'])->whereDate('date',now())->count();

        return view('manager.dashboard.index',compact('totallowproducts','intoday','outtoday'));
    }
}
