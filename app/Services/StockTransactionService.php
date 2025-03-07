<?php

namespace App\Services;

use App\Repositories\Interfaces\StockTransactionRepositoryInterface;

class StockTransactionService
{
    protected $stocktransactionRepository;

    public function __construct(StockTransactionRepositoryInterface $stocktransactionRepository)
    {
        $this->stocktransactionRepository = $stocktransactionRepository;
    }

    public function getAllStockTransactions()
    {
        return $this->stocktransactionRepository->getAll();
    }

    public function getFilteredStockTransactions($search = null)
    {
        return $this->stocktransactionRepository->getFilteredStockTransactions($search);
    }

    public function getFilteredStockTransactionsStaff($search = null)
    {
        return $this->stocktransactionRepository->getFilteredStockTransactionsStaff($search);
    }

    public function getStockTransactionById($id)
    {
        return $this->stocktransactionRepository->findById($id);
    }

    public function createStockTransaction(array $data)
    {
        return $this->stocktransactionRepository->create($data);
    }

    public function updateStockTransaction($id, array $data)
    {
        return $this->stocktransactionRepository->update($id, $data);
    }

    public function deleteStockTransaction($id)
    {
        return $this->stocktransactionRepository->delete($id);
    }
}