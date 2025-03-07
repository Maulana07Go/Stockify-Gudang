<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockOpname;
use App\Services\UserActivityService;
use App\Services\StockTransactionService;

class StockOpnameController extends Controller
{
    protected $useractivityService;
    protected $stocktransactionService;

    public function __construct(UserActivityService $useractivityService, StockTransactionService $stocktransactionService)
    {
        $this->useractivityService = $useractivityService;
        $this->stocktransactionService = $stocktransactionService;
    }

    public function index()
    {
        $opnames = StockOpname::with('product')->latest()->get();
        return view('manager.stock.opname.index', compact('opnames'));
    }

    public function create()
    {
        $products = Product::all();
        return view('manager.stock.opname.create', compact('products'));
    }

    /**
     * Simpan stok opname ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'final_stock' => 'required|integer',
            'notes' => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);
        $initialStock = $product->stock; // Anggap ada atribut `stock` pada model `Product`
        $finalStock = $request->final_stock;
        $difference = $finalStock - $initialStock;
        $date = now();
        $product->update([
            'stock' => $product->stock + $difference
        ]);

        StockOpname::create([
            'product_id' => $product->id,
            'initial_stock' => $initialStock,
            'final_stock' => $finalStock,
            'difference' => $difference,
            'notes' => $request->notes,
            'date' => $date,
        ]);

        $validatedData['user_id'] = auth()->id();
        $validatedData['activity'] = 'Melakukan stock opname pada sebuah produk';
        $validatedData['date'] = now();

        $this->useractivityService->createUserActivity($validatedData);

        if ($difference !=0) {
            $DataValid['user_id'] = auth()->id();
            $DataValid['date'] = now();
            $DataValid['product_id'] = $product->id;
            $DataValid['notes'] = $request->notes;
            if ($difference < 0) {
                $DataValid['type'] = 'Keluar';
                $DataValid['status'] = 'Dikeluarkan';
                $DataValid['quantity'] = abs($difference);
            } else {
                $DataValid['type'] = 'Masuk';
                $DataValid['status'] = 'Diterima';
                $DataValid['quantity'] = $difference;
            }
        }
        $this->stocktransactionService->createStockTransaction($DataValid);

        return redirect()->route('manager.stock.opname.index')->with('success', 'Stok opname berhasil ditambahkan.');
    }
}
