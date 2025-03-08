<?php

namespace App\Repositories\Interfaces;

use App\Models\StockTransaction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface StockTransactionRepositoryInterface
{
    public function getAll(): Collection;
    public function getFilteredStockTransactions($search = null): LengthAwarePaginator;
    public function getFilteredStockTransactionsStaff($search = null): LengthAwarePaginator;
    public function countStockTransactionsToday(string $type, string $status): int;
    public function countStockTransactionsTotal(string $type, string $status): int;
    public function countStockTransactionsThisMonth(string $type, string $status): int;
    public function getStockMovement(int $days = 30): Collection;
    public function getPendingStockTransactions(string $type): Collection;
    public function getStockLatest(): Collection;
    public function getTotalStockIn(): int;
    public function getTotalStockOut(): int;
    public function getFirstTransactionDate(): string;
    public function getLastTransactionDate(): string;
    public function getStockInByCategory(?int $categoryId);
    public function getStockOutByCategory(?int $categoryId);
    public function getStockInitial(?int $categoryId, string $firstDay);
    public function getStockFinal(?int $categoryId, string $lastDay);
    public function getTransactionYears();
    public function getStockTransactionsToday(string $type, string $status): Collection;
    public function findById(int $id): ?StockTransaction;
    public function create(array $data): StockTransaction;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}