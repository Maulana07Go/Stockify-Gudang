<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Exception;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts()
    {
        return $this->productRepository->getAll();
    }

    public function getFilteredProducts($search = null, $categoryId = null)
    {
        return $this->productRepository->getFilteredProducts($search, $categoryId);
    }

    public function countTotalProducts()
    {
        return $this->productRepository->countTotalProducts();
    }

    public function getStockDataByCategory()
    {
        return $this->productRepository->getStockDataByCategory();
    }

    public function countLowStockProducts()
    {
        return $this->productRepository->countLowStockProducts();
    }

    public function getProductsAndMinStock()
    {
        return $this->productRepository->getProductsAndMinStock();
    }

    public function getLowStockProducts()
    {
        return $this->productRepository->getLowStockProducts();
    }

    public function getProductById($id)
    {
        return $this->productRepository->getById($id);
    }

    public function createProduct(array $data)
    {
        try {
            return $this->productRepository->create($data);
        } catch (Exception $e) {
            Log::error('Error creating product: ' . $e->getMessage());
            throw new Exception('Gagal menambahkan produk.');
        }
    }

    public function updateProduct($id, array $data)
    {
        try {
            return $this->productRepository->update($id, $data);
        } catch (Exception $e) {
            Log::error('Error updating product: ' . $e->getMessage());
            throw new Exception('Gagal memperbarui produk.');
        }
    }

    public function deleteProduct($id)
    {
        try {
            return $this->productRepository->delete($id);
        } catch (Exception $e) {
            Log::error('Error deleting product: ' . $e->getMessage());
            throw new Exception('Gagal menghapus produk.');
        }
    }
}