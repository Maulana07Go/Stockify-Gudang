<?php

namespace App\Repositories\Eloquent;

use App\Models\Supplier;
use App\Repositories\Interfaces\SupplierRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SupplierRepository implements SupplierRepositoryInterface
{
    public function getAll(): Collection
    {
        return Supplier::all();
    }

    public function getFilteredSuppliers($search = null): LengthAwarePaginator
    {
        return Supplier::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
        })->paginate(10);
    }

    public function findById(int $id): ?Supplier
    {
        return Supplier::find($id);
    }

    public function create(array $data): Supplier
    {
        return Supplier::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $supplier = Supplier::find($id);
        return $supplier ? $supplier->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $supplier = Supplier::find($id);
        return $supplier ? $supplier->delete() : false;
    }
}