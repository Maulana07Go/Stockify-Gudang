<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Mengambil semua produk dari database
     */
    public function getAll()
    {
        return Product::all(); // Menggunakan Eloquent untuk mengambil semua data
    }

    public function getFilteredProducts($search = null, $categoryId = null): LengthAwarePaginator
    {
        return Product::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                        ->orWhereHas('category', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })
                        ->orWhere('sku', 'like', "%{$search}%");
        })
        ->when($categoryId, function ($query, $categoryId) {
            return $query->where('category_id', $categoryId);
        })->paginate(10);
    }

    public function countTotalProducts(): int
    {
        return Product::count();
    }

    public function getStockDataByCategory(): Collection
    {
        return Product::with('category')
            ->selectRaw('category_id, SUM(stock) as total_stock')
            ->groupBy('category_id')
            ->get();
    }

    public function countLowStockProducts(): int
    {
        return Product::whereColumn('stock', '<', 'minimum_stock')->count();
    }

    public function getProductsAndMinStock(): Collection
    {
        return Product::select('id', 'name', 'minimum_stock')->get();
    }

    public function getLowStockProducts(): Collection
    {
        return Product::whereColumn('stock', '<', 'minimum_stock')->get();
    }

    /**
     * Mengambil satu produk berdasarkan ID
     */
    public function getById($id)
    {
        return Product::findOrFail($id); // Menggunakan Eloquent untuk mencari data berdasarkan ID
    }

    /**
     * Menyimpan produk baru ke database
     */
    public function create(array $data)
    {
        return Product::create($data); // Menggunakan Eloquent untuk menyimpan data
    }

    /**
     * Memperbarui data produk berdasarkan ID
     */
    public function update($id, array $data)
    {
        $product = Product::findOrFail($id);
        $product->update($data);
        return $product;
    }

    /**
     * Menghapus produk berdasarkan ID
     */
    public function delete($id)
    {
        $product = Product::findOrFail($id);
        return $product->delete();
    }
}