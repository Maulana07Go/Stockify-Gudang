<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Services\StockTransactionService;
use App\Services\ProductService;

class LowStockController extends Controller
{
    protected $stocktransactionService;
    protected $productService;

    public function __construct(StockTransactionService $stocktransactionService, ProductService $productService)
    {
        $this->stocktransactionService = $stocktransactionService;
        $this->productService = $productService;
    }

    public function index()
    {
        $lowproducts = $this->productService->getLowStockProducts();
        $intoday = $this->stocktransactionService->countStockTransactionsToday('Masuk', 'Diterima');
        $outtoday = $this->stocktransactionService->countStockTransactionsToday('Keluar', 'Dikeluarkan');

        return view('manager.dashboard.lowstock.index',compact('lowproducts','intoday','outtoday'));
    }
}