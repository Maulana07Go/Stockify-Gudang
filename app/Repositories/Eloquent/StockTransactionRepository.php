<?php

namespace App\Repositories\Eloquent;

use App\Models\StockTransaction;
use App\Repositories\Interfaces\StockTransactionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class StockTransactionRepository implements StockTransactionRepositoryInterface
{
    public function getAll(): Collection
    {
        return StockTransaction::all();
    }

    public function getFilteredStockTransactions($search = null): LengthAwarePaginator
    {
        return StockTransaction::when($search, function ($query, $search) {
            return $query->where('type', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%")
                        ->orWhereHas('product', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%"); // Cari berdasarkan nama produk
                        });
        })
        ->orderBy('date', 'desc')
        ->paginate(10);
    }

    public function getFilteredStockTransactionsStaff($search = null): LengthAwarePaginator
    {
        return StockTransaction::when($search, function ($query, $search) {
            return $query->where('type', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%")
                        ->orWhereHas('product', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%") // Cari berdasarkan nama produk
                            ->orWhere('sku', 'like', "%{$search}%");
                        });
        })
        ->whereIn('status', ['Diterima', 'Ditolak', 'Dikeluarkan'])
        ->orderBy('date', 'desc')
        ->paginate(10);
    }

    public function findById(int $id): ?StockTransaction
    {
        return StockTransaction::find($id);
    }

    public function create(array $data): StockTransaction
    {
        return StockTransaction::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $stocktransaction = StockTransaction::find($id);
        return $stocktransaction ? $stocktransaction->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $stocktransaction = Supplier::find($id);
        return $stocktransaction ? $stocktransaction->delete() : false;
    }
}