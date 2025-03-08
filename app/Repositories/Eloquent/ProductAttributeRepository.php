<?php

namespace App\Repositories\Eloquent;

use App\Models\ProductAttribute;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\ProductAttributeRepositoryInterface;

class ProductAttributeRepository implements ProductAttributeRepositoryInterface
{
    public function getAll(): Collection
    {
        return ProductAttribute::all();
    }

    public function findById(int $id): ?ProductAttribute
    {
        return ProductAttribute::find($id);
    }

    public function create(array $data): ProductAttribute
    {
        return ProductAttribute::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $productattribute = ProductAttribute::find($id);
        return $productattribute ? $productattribute->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $productattribute = ProductAttribute::find($id);
        return $productattribute ? $productattribute->delete() : false;
    }
}