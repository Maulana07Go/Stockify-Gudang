<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockTransaction;

class StaffController extends Controller
{
    public function index()
    {
        $incomingStocks = StockTransaction::with(['product', 'user'])->whereIn('status', ['Pending'])->whereIn('type', ['Masuk'])->latest()->get();
        $outgoingStocks = StockTransaction::with(['product', 'user'])->whereIn('status', ['Pending'])->whereIn('type', ['Keluar'])->latest()->get();

        return view('staff.dashboard.index',compact('incomingStocks', 'outgoingStocks'));
    }
}
