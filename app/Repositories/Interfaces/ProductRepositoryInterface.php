<?php

namespace App\Repositories\Interfaces;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    public function getAll();
    public function getFilteredProducts($search = null, $categoryId = null): LengthAwarePaginator;
    public function countTotalProducts(): int;
    public function getStockDataByCategory(): Collection;
    public function countLowStockProducts(): int;
    public function getProductsAndMinStock(): Collection;
    public function getLowStockProducts(): Collection;
    public function getById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}