<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\UserActivity;
use App\Models\User;
use App\Services\UserActivityService;
use Carbon\Carbon;
use App\Services\StockTransactionService;
use App\Services\ProductService;

class AdminController extends Controller
{
    protected $useractivityService;
    protected $stocktransactionService;
    protected $productService;

    public function __construct(UserActivityService $useractivityService, StockTransactionService $stocktransactionService, ProductService $productService)
    {
        $this->useractivityService = $useractivityService;
        $this->stocktransactionService = $stocktransactionService;
        $this->productService = $productService;
    }

    public function index(Request $request)
    
    {
        $transactionin = $this->stocktransactionService->countStockTransactionsTotal('Masuk', 'Diterima');
        $transactionout = $this->stocktransactionService->countStockTransactionsTotal('Keluar', 'Dikeluarkan'); 
        $totalProducts = $this->productService->countTotalProducts();
        $intoday = $this->stocktransactionService->countStockTransactionsToday('Masuk', 'Diterima');
        $inthismonth = $this->stocktransactionService->countStockTransactionsThisMonth('Masuk', 'Diterima');
        $outtoday = $this->stocktransactionService->countStockTransactionsToday('Keluar', 'Dikeluarkan');
        $outthismonth = $this->stocktransactionService->countStockTransactionsThisMonth('Keluar', 'Dikeluarkan');
        $search = $request->input('search');
        $useractivities = $this->useractivityService->getFilteredUserActivity($search);
        $usernames = User::whereIn('id', $useractivities->pluck('user_id'))->get();

        $stockData = $this->productService->getStockDataByCategory();

        // Konversi ID kategori menjadi nama kategori
        $stockData->each(function ($item) {
            $item->category_name = optional($item->category)->name;
        });

        // Mengambil data pergerakan stok (barang masuk dan keluar) dalam 30 hari terakhir
        $stockMovement = $this->stocktransactionService->getStockMovement(30);

        return view('admin.dashboard.index', compact('transactionin', 'transactionout', 'totalProducts', 'useractivities', 'usernames', 'intoday', 'outtoday', 'inthismonth','outthismonth', 'stockData', 'stockMovement'));
    }
}
