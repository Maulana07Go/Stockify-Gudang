<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Services\StockTransactionService;
use App\Services\ProductService;

class ManagerController extends Controller
{
    protected $stocktransationService;
    protected $productService;

    public function __construct(StockTransactionService $stocktransactionService, ProductService $productService)
    {
        $this->stocktransactionService = $stocktransactionService;
        $this->productService = $productService;
    }

    public function index()
    {
        $totallowproducts = $this->productService->countLowStockProducts();
        $intoday = $this->stocktransactionService->countStockTransactionsToday('Masuk', 'Diterima');
        $outtoday = $this->stocktransactionService->countStockTransactionsToday('Keluar', 'Dikeluarkan');

        return view('manager.dashboard.index',compact('totallowproducts','intoday','outtoday'));
    }
}
