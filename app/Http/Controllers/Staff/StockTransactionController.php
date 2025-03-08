<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockTransaction;
use App\Services\StockTransactionService;

class StockTransactionController extends Controller
{
    protected $stocktransationService;

    public function __construct(StockTransactionService $stocktransactionService)
    {
        $this->stocktransactionService = $stocktransactionService;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $transactions = $this->stocktransactionService->getFilteredStockTransactionsStaff($search);
        return view('staff.stock.index', compact('transactions', 'search'));
    }

    public function show($id)
    {
        $transaction = $this->stocktransactionService->getStockTransactionById($id); // Ambil data transaksi berdasarkan ID

        return view('staff.stock.show', compact('transaction'));
    }
}
