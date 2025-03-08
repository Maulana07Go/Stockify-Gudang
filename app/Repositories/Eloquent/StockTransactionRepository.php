<?php

namespace App\Repositories\Eloquent;

use App\Models\StockTransaction;
use App\Repositories\Interfaces\StockTransactionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

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

    public function countStockTransactionsToday(string $type, string $status): int
    {
        return StockTransaction::where('type', $type)
            ->where('status', $status)
            ->whereDate('date', now())
            ->count();
    }

    public function countStockTransactionsThisMonth(string $type, string $status): int
    {
        return StockTransaction::where('type', $type)
            ->where('status', $status)
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->count();
    }

    public function countStockTransactionsTotal(string $type, string $status): int
    {
        return StockTransaction::where('type', $type)
            ->where('status', $status)
            ->count();
    }

    public function getStockMovement(int $days = 30): Collection
    {
        return StockTransaction::selectRaw(
                'DATE(date) as date, 
                 SUM(CASE WHEN type = "Masuk" THEN quantity ELSE 0 END) as stock_in,
                 SUM(CASE WHEN type = "Keluar" THEN quantity ELSE 0 END) as stock_out'
            )
            ->where('date', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    public function getPendingStockTransactions(string $type): Collection
    {
        return StockTransaction::with(['product', 'user'])
            ->where('status', 'Pending')
            ->where('type', $type)
            ->latest()
            ->get();
    }

    public function getStockLatest(): Collection
    {
        return StockTransaction::with(['product', 'user'])
            ->latest()
            ->get();
    }

    public function getTotalStockIn(): int
    {
        return StockTransaction::whereIn('type', ['Masuk'])
            ->whereIn('status', ['Diterima'])
            ->sum('quantity');
    }

    public function getTotalStockOut(): int
    {
        return StockTransaction::whereIn('type', ['Keluar'])
            ->whereIn('status', ['Dikeluarkan'])
            ->sum('quantity');
    }

    public function getFirstTransactionDate(): string
    {
        return StockTransaction::min('date') ?? now()->format('Y-m-d');
    }

    public function getLastTransactionDate(): string
    {
        return StockTransaction::max('date') ?? now()->format('Y-m-d');
    }

    public function getStockInByCategory(?int $categoryId)
    {
        return StockTransaction::where('type', 'Masuk')
            ->where('status', 'Diterima')
            ->whereHas('product', function ($query) use ($categoryId) {
                if ($categoryId) {
                    $query->where('category_id', $categoryId);
                }
            })
            ->selectRaw('product_id, SUM(quantity) as total_quantity')
            ->groupBy('product_id');
    }

    public function getStockOutByCategory(?int $categoryId)
    {
        return StockTransaction::where('type', 'Keluar')
            ->where('status', 'Dikeluarkan')
            ->whereHas('product', function ($query) use ($categoryId) {
                if ($categoryId) {
                    $query->where('category_id', $categoryId);
                }
            })
            ->selectRaw('product_id, SUM(quantity) as total_quantity')
            ->groupBy('product_id');
    }

    public function getStockInitial(?int $categoryId, string $firstDay)
    {
        return StockTransaction::whereIn('type', ['Masuk', 'Keluar'])
            ->whereIn('status', ['Diterima', 'Dikeluarkan'])
            ->whereHas('product', function ($query) use ($categoryId) {
                if ($categoryId) {
                    $query->where('category_id', $categoryId);
                }
            })
            ->whereDate('date', '<', $firstDay)
            ->selectRaw('product_id, SUM(CASE WHEN type = "Masuk" THEN quantity ELSE -quantity END) as total_stock')
            ->groupBy('product_id');
    }

    public function getStockFinal(?int $categoryId, string $lastDay)
    {
        return StockTransaction::whereIn('type', ['Masuk', 'Keluar'])
            ->whereIn('status', ['Diterima', 'Dikeluarkan'])
            ->whereHas('product', function ($query) use ($categoryId) {
                if ($categoryId) {
                    $query->where('category_id', $categoryId);
                }
            })
            ->whereDate('date', '<=', $lastDay)
            ->selectRaw('product_id, SUM(CASE WHEN type = "Masuk" THEN quantity ELSE -quantity END) as total_stock')
            ->groupBy('product_id');
    }

    public function getTransactionYears()
    {
        return StockTransaction::selectRaw('YEAR(date) as year')
            ->distinct()
            ->pluck('year');
    }

    public function getStockTransactionsToday(string $type, string $status): Collection
    {
        return StockTransaction::where('type', $type)
            ->where('status', $status)
            ->whereDate('date', now())
            ->get();
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