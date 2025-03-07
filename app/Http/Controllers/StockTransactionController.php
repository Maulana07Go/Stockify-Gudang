<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockTransaction;

class StockTransactionController extends Controller
{
    public function index()
    {
        $transactions = StockTransaction::with(['product', 'user'])->latest()->get();
        return view('admin.stock.index', compact('transactions'));
    }
}
