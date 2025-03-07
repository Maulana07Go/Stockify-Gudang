<?php

namespace App\Services;

use App\Repositories\Interfaces\SupplierRepositoryInterface;

class SupplierService
{
    protected $supplierRepository;

    public function __construct(SupplierRepositoryInterface $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    public function getAllSuppliers()
    {
        return $this->supplierRepository->getAll();
    }

    public function getFilteredSuppliers($search = null)
    {
        return $this->supplierRepository->getFilteredSuppliers($search);
    }

    public function getSupplierById($id)
    {
        return $this->supplierRepository->findById($id);
    }

    public function createSupplier(array $data)
    {
        return $this->supplierRepository->create($data);
    }

    public function updateSupplier($id, array $data)
    {
        return $this->supplierRepository->update($id, $data);
    }

    public function deleteSupplier($id)
    {
        return $this->supplierRepository->delete($id);
    }
}