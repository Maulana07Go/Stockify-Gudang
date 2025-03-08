<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockTransaction;
use App\Models\Product;
use App\Services\UserActivityService;
use App\Services\StockTransactionService;
use App\Services\ProductService;

class StockTransactionController extends Controller
{
    protected $useractivityService;
    protected $stocktransationService;
    protected $productService;

    public function __construct(UserActivityService $useractivityService, StockTransactionService $stocktransactionService, ProductService $productService)
    {
        $this->useractivityService = $useractivityService;
        $this->stocktransactionService = $stocktransactionService;
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $transactions = $this->stocktransactionService->getFilteredStockTransactions($search);
        return view('manager.stock.index', compact('transactions', 'search'));
    }

    public function create()
    {
        $products = $this->productService->getAllProducts(); // Ambil daftar produk
        return view('manager.stock.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:Masuk,Keluar',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        // Tambahkan data otomatis
        $validatedData['user_id'] = auth()->id();
        $validatedData['status'] = 'Pending';
        $validatedData['date'] = now();

        $this->stocktransactionService->createStockTransaction($validatedData);

        $vali['user_id'] = auth()->id();
        $vali['activity'] = 'Membuat transaksi stok baru';
        $vali['date'] = now();

        $this->useractivityService->createUserActivity($vali);

        return redirect()->route('manager.stock.index')->with('success', 'Transaksi stok berhasil ditambahkan.');
    }

    public function show($id)
    {
        $transaction = $this->stocktransactionService->getStockTransactionById($id); // Ambil data transaksi berdasarkan ID

        return view('manager.stock.show', compact('transaction'));
    }
}
