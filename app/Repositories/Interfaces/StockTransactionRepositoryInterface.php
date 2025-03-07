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
    public function findById(int $id): ?StockTransaction;
    public function create(array $data): StockTransaction;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}