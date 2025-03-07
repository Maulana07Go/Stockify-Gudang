<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

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