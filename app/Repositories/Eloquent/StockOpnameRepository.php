<?php

namespace App\Repositories\Eloquent;

use App\Models\StockOpname;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\StockOpnameRepositoryInterface;

class StockOpnameRepository implements StockOpnameRepositoryInterface
{
    public function getAll(): Collection
    {
        return StockOpname::all();
    }

    public function getAllStockOpnameWithProduct(): Collection
    {
        return StockOpname::with('product')->latest()->get();
    }

    public function findById(int $id): ?StockOpname
    {
        return StockOpname::find($id);
    }

    public function create(array $data): StockOpname
    {
        return StockOpname::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $stockopname = StockOpname::find($id);
        return $stockopname ? $stockopname->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $stockopname = StockOpname::find($id);
        return $stockopname ? $stockopname->delete() : false;
    }
}