<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockTransaction;
use App\Models\Product;
use App\Services\UserActivityService;
use App\Services\StockTransactionService;
use App\Services\ProductService;

class InConfirmStockTransactionController extends Controller
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

    public function index()
    {
        $transactions = $this->stocktransactionService->getPendingStockTransactions('Masuk');
        return view('staff.stock.inconfirm.index', compact('transactions'));
    }

    /**
     * Menampilkan form edit transaksi stok.
     */
    public function edit($id)
    {
        $transaction = $this->stocktransactionService->getStockTransactionById($id);
        $product = $this->productService->getProductById($transaction->product_id);
        session(['previous_url' => url()->previous()]);
        return view('staff.stock.inconfirm.edit', compact('transaction', 'product'));
    }

    /**
     * Memperbarui transaksi stok di database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Diterima,Ditolak',
            'notes' => 'nullable|string'
        ]);

        $request['date'] = now();

        $transaction = $this->stocktransactionService->getStockTransactionById($id);
        $transaction->update([
            'date' => $request->date,
            'status' => $request->status,
            'notes' => $request->notes
        ]);

        if ($transaction->status === 'Diterima') {

            $product = $this->productService->getProductById($transaction->product_id);
            $product->update([
                'stock' => $product->stock + $transaction->quantity
            ]);
            $vali['user_id'] = auth()->id();
            $vali['activity'] = 'Menerima sebuah transaksi masuk';
            $vali['date'] = now();

            $this->useractivityService->createUserActivity($vali);
        } elseif ($request->status === 'Ditolak') {
            $transaction->update([
                'date' => $request->date,
                'status' => $request->status,
                'notes' => $request->notes
            ]);
            $vali['user_id'] = auth()->id();
            $vali['activity'] = 'Menolak sebuah transaksi masuk';
            $vali['date'] = now();

            $this->useractivityService->createUserActivity($vali);
        }

        return redirect()->route('staff.stock.inconfirm.index')->with('success', 'Transaksi stok berhasil diperbarui.');
    }
}
