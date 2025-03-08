<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockTransaction;
use App\Services\StockTransactionService;

class StaffController extends Controller
{
    protected $stocktransactionService;

    public function __construct(StockTransactionService $stocktransactionService)
    {
        $this->stocktransactionService = $stocktransactionService;
    }

    public function index()
    {
        $incomingStocks = $this->stocktransactionService->getPendingStockTransactions('Masuk');
        $outgoingStocks = $this->stocktransactionService->getPendingStockTransactions('keluar');

        return view('staff.dashboard.index',compact('incomingStocks', 'outgoingStocks'));
    }
}
