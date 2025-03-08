<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Services\StockTransactionService;
use App\Services\ProductService;

class OutTodayController extends Controller
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
        $intodays = $this->stocktransactionService->getStockTransactionsToday('Masuk', 'Diterima');
        $outtodays = $this->stocktransactionService->getStockTransactionsToday('Keluar', 'Dikeluarkan');

        return view('manager.dashboard.outtoday.index',compact('lowproducts','intodays','outtodays'));
    }
}