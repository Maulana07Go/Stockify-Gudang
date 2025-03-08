<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;
use App\Services\CategoryService;
use Illuminate\Support\Facades\Storage;
use App\Services\SupplierService;

class ProductController extends Controller
{
    protected $productService;
    protected $categoryService;
    protected $supplierService;

    public function __construct(ProductService $productService, CategoryService $categoryService,  SupplierService $supplierService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->supplierService = $supplierService;
    }

    /**
     * Menampilkan daftar produk.
     */
    public function index(Request $request)
    {
        $categories = $this->categoryService->getAllCategories();
        $categoryId = $request->input('category_id');
        $search = $request->input('search');
        $products = $this->productService->getFilteredProducts($search, $categoryId);
        return view('manager.product.index', compact('products', 'categories', 'categoryId'));
    }

    /**
     * Menampilkan halaman tambah produk.
     */
    public function create()
    {
        $categories = $this->categoryService->getAllCategories();
        $suppliers = $this->supplierService->getAllSuppliers();

        return view('manager.product.create', compact('categories', 'suppliers'));
    }

    /**
     * Menyimpan produk baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku',
            'description' => 'nullable|string',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'minimum_stock' => 'required|integer',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $this->productService->createProduct($data);

        return redirect()->route('manager.product.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail produk.
     */
    public function show($id)
    {
        $product = $this->productService->getProductById($id);
        return view('manager.product.show', compact('product'));
    }

    /**
     * Menampilkan halaman edit produk.
     */
    public function edit($id)
    {
        $product = $this->productService->getProductById($id);
        $categories = $this->categoryService->getAllCategories();
        $suppliers = $this->supplierService->getAllSuppliers();

        return view('manager.product.edit', compact('product', 'categories', 'suppliers'));
    }

    /**
     * Memperbarui produk.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku,' . $id,
            'description' => 'nullable|string',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'minimum_stock' => 'required|integer',
        ]);

        $product = $this->productService->getProductById($id);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        } else {
            $data['image'] = $product->image;
        }

        $this->productService->updateProduct($id, $data);

        return redirect()->route('manager.product.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Menghapus produk.
     */
    public function destroy($id)
    {
        $this->productService->deleteProduct($id);
        return redirect()->route('manager.product.index')->with('success', 'Produk berhasil dihapus.');
    }
}
