<?php

namespace App\Repositories\Interfaces;

use App\Models\StockOpname;
use Illuminate\Database\Eloquent\Collection;

interface StockOpnameRepositoryInterface
{
    public function getAll(): Collection;
    public function getAllStockOpnameWithProduct(): Collection;
    public function findById(int $id): ?StockOpname;
    public function create(array $data): StockOpname;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}