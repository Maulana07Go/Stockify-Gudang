<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockTransaction;
use App\Models\Product;
use App\Services\UserActivityService;

class OutConfirmStockTransactionController extends Controller
{
    protected $useractivityService;

    public function __construct(UserActivityService $useractivityService)
    {
        $this->useractivityService = $useractivityService;
    }

    public function index()
    {
        $transactions = StockTransaction::with(['product', 'user'])->whereIn('status', ['Pending'])->whereIn('type', ['Keluar'])->latest()->get();
        return view('staff.stock.outconfirm.index', compact('transactions'));
    }

    /**
     * Menampilkan form edit transaksi stok.
     */
    public function edit($id)
    {
        $transaction = StockTransaction::findOrFail($id);
        $product = Product::findOrFail($transaction->product_id);
        session(['previous_url' => url()->previous()]);
        return view('staff.stock.outconfirm.edit', compact('transaction', 'product'));
    }

    /**
     * Memperbarui transaksi stok di database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Dikeluarkan,Ditolak',
            'notes' => 'nullable|string'
        ]);

        $request['date'] = now();

        $transaction = StockTransaction::findOrFail($id);

        if ($request->status === 'Dikeluarkan') {
            $product = Product::findOrFail($transaction->product_id);
            if ($product->stock >= $transaction->quantity) {
                $product->update([
                    'stock' => $product->stock - $transaction->quantity
                ]);
                $transaction->update([
                    'date' => $request->date,
                    'status' => $request->status,
                    'notes' => $request->notes
                ]);
                $vali['user_id'] = auth()->id();
                $vali['activity'] = 'Menerima sebuah transaksi keluar';
                $vali['date'] = now();

                $this->useractivityService->createUserActivity($vali);
            } elseif ($product->stock < $transaction->quantity) {
                return back()->with('error', 'Stok tidak mencukupi!');
            }
        } elseif ($request->status === 'Ditolak') {
            $transaction->update([
                'date' => $request->date,
                'status' => $request->status,
                'notes' => $request->notes
            ]);
            $vali['user_id'] = auth()->id();
            $vali['activity'] = 'Menolak sebuah transaksi keluar';
            $vali['date'] = now();

            $this->useractivityService->createUserActivity($vali);
        }

        return redirect()->route('staff.stock.outconfirm.index')->with('success', 'Transaksi stok berhasil diperbarui.');
    }
}
