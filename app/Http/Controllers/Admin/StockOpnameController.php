<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockOpname;
use App\Services\UserActivityService;
use App\Services\ProductService;
use App\Services\StockOpnameService;

class StockOpnameController extends Controller
{
    protected $useractivityService;
    protected $productService;
    protected $stockopnameService;

    public function __construct(UserActivityService $useractivityService, ProductService $productService, StockOpnameService $stockopnameService)
    {
        $this->useractivityService = $useractivityService;
        $this->productService = $productService;
        $this->stockopnameService = $stockopnameService;
    }

    public function index()
    {
        $opnames = $this->stockopnameService->getAllStockOpnameWithProduct();
        return view('admin.stock.opname.index', compact('opnames'));
    }

    public function create()
    {
        $products = $this->productService->getAllProducts();
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

        $product = $this->productService->getProductById()($request->product_id);
        $initialStock = $product->stock; // Anggap ada atribut `stock` pada model `Product`
        $finalStock = $request->final_stock;
        $difference = $finalStock - $initialStock;
        $date = now();
        $product->update([
            'stock' => $product->stock + $difference
        ]);

        $this->stockopnameService->createStockOpname([
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
