<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockTransaction;
use App\Services\StockTransactionService;

class StockTransactionController extends Controller
{
    protected $stocktransactionService;

    public function __construct(StockTransactionService $stocktransactionService)
    {
        $this->stocktransactionService = $stocktransactionService;
    }

    public function index()
    {
        $transactions = $this->stocktransactionService->getAllStockTransactions();
        return view('admin.stock.index', compact('transactions'));
    }
}
