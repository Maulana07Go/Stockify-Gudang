<?php

namespace App\Repositories\Interfaces;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function getAll();
    public function getFilteredProducts($search = null, $categoryId = null): LengthAwarePaginator;
    public function getById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}