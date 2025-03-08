<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Services\ProductAttributeService;

class ProductAttributeController extends Controller
{
    protected $productattributeService;

    public function __construct(ProductAttributeService $productattributeService)
    {
        $this->productattributeService = $productattributeService;
    }

    // Form Tambah Atribut
    public function create(Product $product)
    {
        return view('admin.product.attribute.create', compact('product'));
    }

    // Simpan Atribut Baru
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|string|max:255',
        ]);

        // Jika produk sudah memiliki atribut, buat produk baru dengan data yang sama
        if ($product->attributes()->exists()) {
            $newProduct = $product->replicate(); // Duplikasi data produk
            $newProduct->sku = $this->generateUniqueSKU(); // Buat SKU baru
            
            // Set nilai stok dan lainnya menjadi 0
            $newProduct->minimum_stock = 0;
            $newProduct->stock = 0;
            $newProduct->reorder_point = 0;
            $newProduct->average_usage = 0;
            $newProduct->average_lead_time = 0;
            
            $newProduct->save();

            $product = $newProduct; // Gunakan produk baru sebagai produk utama untuk atribut baru
        }

        // Simpan atribut baru ke dalam produk yang dipilih
        $this->productattributeService->createProductAttribute([
            'product_id' => $product->id,
            'name' => $request->name,
            'value' => $request->value,
        ]);

        return redirect()->route('admin.product.show', $product->id)->with('success', 'Atribut berhasil ditambahkan.');
    }

    /**
     * Fungsi untuk membuat SKU unik.
     */
    private function generateUniqueSKU()
    {
        do {
            $sku = 'PROD-' . strtoupper(uniqid()); // Contoh SKU unik
        } while (Product::where('sku', $sku)->exists());

        return $sku;
    }

    // Form Edit Atribut
    public function edit(ProductAttribute $attribute)
    {
        return view('admin.product.attribute.edit', compact('attribute'));
    }

    // Update Atribut
    public function update(Request $request, ProductAttribute $attribute)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|string|max:255',
        ]);

        $attribute->update([
            'name' => $request->name,
            'value' => $request->value,
        ]);

        return redirect()->route('admin.product.show', $attribute->product_id)->with('success', 'Atribut berhasil diperbarui.');
    }
}
