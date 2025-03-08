<?php

namespace App\Repositories\Interfaces;

use App\Models\ProductAttribute;
use Illuminate\Database\Eloquent\Collection;

interface ProductAttributeRepositoryInterface
{
    public function getAll(): Collection;
    public function findById(int $id): ?ProductAttribute;
    public function create(array $data): ProductAttribute;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}