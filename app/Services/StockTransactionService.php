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

    public function countStockTransactionsToday(string $type, string $status)
    {
        return $this->stocktransactionRepository->countStockTransactionsToday($type, $status);
    }

    public function countStockTransactionsThisMonth(string $type, string $status)
    {
        return $this->stocktransactionRepository->countStockTransactionsThisMonth($type, $status);
    }

    public function countStockTransactionsTotal(string $type, string $status)
    {
        return $this->stocktransactionRepository->countStockTransactionsTotal($type, $status);
    }

    public function getStockMovement(int $days = 30)
    {
        return $this->stocktransactionRepository->getStockMovement($days);
    }

    public function getPendingStockTransactions(string $type)
    {
        return $this->stocktransactionRepository->getPendingStockTransactions($type);
    }

    public function getStockLatest()
    {
        return $this->stocktransactionRepository->getStockLatest();
    }

    public function getTotalStockIn()
    {
        return $this->stocktransactionRepository->getTotalStockIn();
    }

    public function getTotalStockOut()
    {
        return $this->stocktransactionRepository->getTotalStockOut();
    }

    public function getFirstTransactionDate()
    {
        return $this->stocktransactionRepository->getFirstTransactionDate();
    }

    public function getLastTransactionDate()
    {
        return $this->stocktransactionRepository->getLastTransactionDate();
    }

    public function getStockInByCategory(?int $categoryId)
    {
        return $this->stocktransactionRepository->getStockInByCategory($categoryId);
    }

    public function getStockOutByCategory(?int $categoryId)
    {
        return $this->stocktransactionRepository->getStockOutByCategory($categoryId);
    }

    public function getStockInitial(?int $categoryId, string $firstDay)
    {
        return $this->stocktransactionRepository->getStockInitial($categoryId, $firstDay);
    }

    public function getStockFinal(?int $categoryId, string $lastDay)
    {
        return $this->stocktransactionRepository->getStockFinal($categoryId, $lastDay);
    }

    public function getTransactionYears()
    {
        return $this->stocktransactionRepository->getTransactionYears();
    }

    public function getStockTransactionsToday(string $type, string $status)
    {
        return $this->stocktransactionRepository->getStockTransactionsToday($type, $status);
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