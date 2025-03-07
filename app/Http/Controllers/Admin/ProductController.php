<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\UserActivity;
use App\Services\CategoryService;
use App\Services\UserActivityService;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $productService;
    protected $categoryService;
    protected $useractivityService;

    public function __construct(ProductService $productService, CategoryService $categoryService, UserActivityService $useractivityService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->useractivityService = $useractivityService;
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
        return view('admin.product.index', compact('products', 'categories', 'categoryId'));
    }

    /**
     * Menampilkan halaman tambah produk.
     */
    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();

        return view('admin.product.create', compact('categories', 'suppliers'));
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
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $this->productService->createProduct($data);

        $validatedData['user_id'] = auth()->id();
        $validatedData['activity'] = 'Menambahkan produk baru';
        $validatedData['date'] = now();

        $this->useractivityService->createUserActivity($validatedData);

        return redirect()->route('admin.product.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail produk.
     */
    public function show($id)
    {
        $product = $this->productService->getProductById($id);
        return view('admin.product.show', compact('product'));
    }

    /**
     * Menampilkan halaman edit produk.
     */
    public function edit($id)
    {
        $product = $this->productService->getProductById($id);
        $categories = Category::all();
        $suppliers = Supplier::all();

        return view('admin.product.edit', compact('product', 'categories', 'suppliers'));
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

        $validatedData['user_id'] = auth()->id();
        $validatedData['activity'] = 'Memperbarui data produk';
        $validatedData['date'] = now();

        $this->useractivityService->createUserActivity($validatedData);

        return redirect()->route('admin.product.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Menghapus produk.
     */
    public function destroy($id)
    {
        $this->productService->deleteProduct($id);
        
        $validatedData['user_id'] = auth()->id();
        $validatedData['activity'] = 'Menghapus sebuah produk';
        $validatedData['date'] = now();

        $this->useractivityService->createUserActivity($validatedData);

        return redirect()->route('admin.product.index')->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Export CSV untuk Produk
     */
    public function exportCsv()
    {
        $fileName = 'product_report.csv';
        $products = Product::all();

        $headers = [
            "Content-Type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($products) {
            $file = fopen('php://output', 'w');

            // Header CSV
            fputcsv($file, [
                'ID', 'Category ID', 'Supplier ID', 'Name', 'SKU', 'Description',
                'Purchase Price', 'Selling Price', 'Minimum Stock', 'Stock',
                'Reorder Point', 'Average Usage', 'Average Lead Time'
            ]);

            // Data Produk
            foreach ($products as $product) {
                fputcsv($file, [
                    $product->id,
                    $product->category_id,
                    $product->supplier_id,
                    $product->name,
                    $product->sku,
                    $product->description,
                    $product->purchase_price,
                    $product->selling_price,
                    $product->minimum_stock,
                    $product->stock,
                    $product->reorder_point,
                    $product->average_usage,
                    $product->average_lead_time
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Import CSV untuk Produk
     */
    public function importCsv(Request $request)
    {
        $file = $request->file('csv_file');

        if (!$file) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        $handle = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($handle, 1000, ","); // Ambil header CSV

        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            Product::create([
                "category_id"       => $data[1],
                "supplier_id"       => $data[2],
                "name"              => $data[3],
                "sku"               => $data[4],
                "description"       => $data[5],
                "purchase_price"    => $data[6],
                "selling_price"     => $data[7],
                "minimum_stock"     => $data[8],
                "stock"             => $data[9],
                "reorder_point"     => $data[10],
                "average_usage"     => $data[11],
                "average_lead_time" => $data[12],
            ]);
        }

        fclose($handle);

        return back()->with('success', 'Data produk berhasil diimport.');
    }

}