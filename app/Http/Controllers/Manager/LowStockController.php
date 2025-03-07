<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockTransaction;

class LowStockController extends Controller
{
    public function index()
    {
        $lowproducts = Product::whereColumn('stock', '<', 'minimum_stock')->get();
        $intoday = StockTransaction::whereIn('type', ['Masuk'])->whereIn('status',['Diterima'])->whereDate('date',now())->count();
        $outtoday = StockTransaction::whereIn('type', ['Keluar'])->whereIn('status',['Dikeluarkan'])->whereDate('date',now())->count();

        return view('manager.dashboard.lowstock.index',compact('lowproducts','intoday','outtoday'));
    }
}