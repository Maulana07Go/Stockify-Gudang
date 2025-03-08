<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductAttributeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProductAttributeService
{
    protected $productattributeRepository;

    public function __construct(ProductAttributeRepositoryInterface $productattributeRepository)
    {
        $this->productattributeRepository = $productattributeRepository;
    }

    public function getAllProductAttributes(): Collection
    {
        return $this->productattributeRepository->getAll();
    }

    public function getProductAttributeById(int $id)
    {
        return $this->productattributeRepository->findById($id);
    }

    public function createProductAttribute(array $data)
    {
        return $this->productattributeRepository->create($data);
    }

    public function updateProductAttribute(int $id, array $data)
    {
        return $this->productattributeRepository->update($id, $data);
    }

    public function deleteProductAttribute(int $id)
    {
        return $this->productattributeRepository->delete($id);
    }
}