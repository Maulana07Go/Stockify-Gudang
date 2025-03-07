<?php

namespace App\Repositories\Interfaces;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface SupplierRepositoryInterface
{
    public function getAll(): Collection;
    public function getFilteredSuppliers($search = null): LengthAwarePaginator;
    public function findById(int $id): ?Supplier;
    public function create(array $data): Supplier;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}