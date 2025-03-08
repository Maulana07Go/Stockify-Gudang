<?php

namespace App\Services;

use App\Repositories\Interfaces\StockOpnameRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class StockOpnameService
{
    protected $stockopnameRepository;

    public function __construct(StockOpnameRepositoryInterface $stockopnameRepository)
    {
        $this->stockopnameRepository = $stockopnameRepository;
    }

    public function getAllStockOpnames(): Collection
    {
        return $this->stockopnameRepository->getAll();
    }

    public function getAllStockOpnameWithProduct(): Collection
    {
        return $this->stockopnameRepository->getAllStockOpnameWithProduct();
    }

    public function getStockOpnameById(int $id)
    {
        return $this->stockopnameRepository->findById($id);
    }

    public function createStockOpname(array $data)
    {
        return $this->stockopnameRepository->create($data);
    }

    public function updateStockOpname(int $id, array $data)
    {
        return $this->stockopnameRepository->update($id, $data);
    }

    public function deleteStockOpname(int $id)
    {
        return $this->stockopnameRepository->delete($id);
    }
}