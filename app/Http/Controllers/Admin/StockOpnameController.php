<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockOpname;
use App\Services\UserActivityService;

class StockOpnameController extends Controller
{
    protected $useractivityService;

    public function __construct(UserActivityService $useractivityService)
    {
        $this->useractivityService = $useractivityService;
    }

    public function index()
    {
        $opnames = StockOpname::with('product')->latest()->get();
        return view('admin.stock.opname.index', compact('opnames'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.stock.opname.create', compact('products'));
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

        return redirect()->route('admin.stock.opname.index')->with('success', 'Stok opname berhasil ditambahkan.');
    }
}
