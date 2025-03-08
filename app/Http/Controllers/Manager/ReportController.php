<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Models\StockTransaction;
use App\Models\Category;
use App\Services\StockTransactionService;
use App\Services\CategoryService;

class ReportController extends Controller
{
    protected $productService;
    protected $stocktransactionService;
    protected $categoryService;

    public function __construct(ProductService $productService, StockTransactionService $stocktransactionService, CategoryService $categoryService)
    {
        $this->productService = $productService;
        $this->stocktransactionService = $stocktransactionService;
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category_id');
        $products = $this->productService->getFilteredProducts($search, $categoryId);
        $totalstokmasuk = $this->stocktransactionService->getTotalStockIn();
        $totalstokkeluar = $this->stocktransactionService->getTotalStockOut();
        // Ambil input dari form dropdown
        $yearStart = $request->input('year_start');
        $yearEnd = $request->input('year_end');
        $monthStart = $request->input('month_start');
        $monthEnd = $request->input('month_end');
        $dateStart = $request->input('date_start');
        $dateEnd = $request->input('date_end');
        $firstDay = $this->stocktransactionService->getFirstTransactionDate(); // Tanggal transaksi pertama
        $lastDay = $this->stocktransactionService->getLastTransactionDate();  // Tanggal transaksi terakhir

        // Query untuk filter berdasarkan input
        $queryStockMasuk = $this->stocktransactionService->getStockInByCategory($categoryId);

        $queryStockKeluar = $this->stocktransactionService->getStockOutByCategory($categoryId);

        // Filter berdasarkan tahun
        if ($yearStart && $yearEnd) {
            $queryStockMasuk->whereYear('date', '>=', $yearStart)
                ->whereYear('date', '<=', $yearEnd);
            $queryStockKeluar->whereYear('date', '>=', $yearStart)
                ->whereYear('date', '<=', $yearEnd);
            $firstDay = $yearStart . '-01-01';
            $lastDay = $yearEnd . '-12-31';
        }

        // Filter berdasarkan bulan
        if ($yearStart && $yearEnd && $monthStart && $monthEnd) {
            if ($yearStart != $yearEnd) {
                $queryStockMasuk->where(function ($q) use ($yearStart, $yearEnd, $monthStart, $monthEnd) {
                    $q->where(function ($subQ) use ($yearStart, $monthStart) {
                        $subQ->whereYear('date', '=', $yearStart)
                             ->whereMonth('date', '>=', $monthStart);
                    })
                    ->orWhere(function ($subQ) use ($yearEnd, $monthEnd) {
                        $subQ->whereYear('date', '=', $yearEnd)
                             ->whereMonth('date', '<=', $monthEnd);
                    })
                    ->orWhereBetween('date', [
                        date("$yearStart-12-31"), 
                        date("$yearEnd-01-01")
                    ]);
                });

                $queryStockKeluar->where(function ($q) use ($yearStart, $yearEnd, $monthStart, $monthEnd) {
                    $q->where(function ($subQ) use ($yearStart, $monthStart) {
                        $subQ->whereYear('date', '=', $yearStart)
                             ->whereMonth('date', '>=', $monthStart);
                    })
                    ->orWhere(function ($subQ) use ($yearEnd, $monthEnd) {
                        $subQ->whereYear('date', '=', $yearEnd)
                             ->whereMonth('date', '<=', $monthEnd);
                    })
                    ->orWhereBetween('date', [
                        date("$yearStart-12-31"), 
                        date("$yearEnd-01-01")
                    ]);
                });
                $firstDay = $yearStart . '-' . str_pad($monthStart, 2, '0', STR_PAD_LEFT) . '-01';
                $lastDay = $yearEnd . '-' . str_pad($monthEnd, 2, '0', STR_PAD_LEFT) . '-' . cal_days_in_month(CAL_GREGORIAN, $monthEnd, $yearEnd);
            } else {
                $queryStockMasuk->whereMonth('date', '>=', $monthStart)
                      ->whereMonth('date', '<=', $monthEnd);
                $queryStockKeluar->whereMonth('date', '>=', $monthStart)
                      ->whereMonth('date', '<=', $monthEnd);
                $firstDay = $yearStart . '-' . str_pad($monthStart, 2, '0', STR_PAD_LEFT) . '-01';
                $lastDay = $yearEnd . '-' . str_pad($monthEnd, 2, '0', STR_PAD_LEFT) . '-' . cal_days_in_month(CAL_GREGORIAN, $monthEnd, $yearEnd);
            }
        }

        // Filter berdasarkan tanggal tertentu
        if ($dateStart && $dateEnd) {
            $queryStockMasuk->whereDate('date', '>=', $dateStart)
                ->whereDate('date', '<=', $dateEnd);
            $queryStockKeluar->whereDate('date', '>=', $dateStart)
                ->whereDate('date', '<=', $dateEnd);
            $firstDay = $dateStart;
            $lastDay = $dateEnd;
        }

        // Hitung total stok masuk berdasarkan filter
        $totalStockMasuk = $queryStockMasuk->pluck('total_quantity', 'product_id');
        $totalStockKeluar = $queryStockKeluar->pluck('total_quantity', 'product_id');

        $queryStockAwal = $this->stocktransactionService->getStockInitial($categoryId, $firstDay);

        $queryStockAkhir = $this->stocktransactionService->getStockFinal($categoryId, $lastDay);

            $stockAwal = $queryStockAwal->pluck('total_stock', 'product_id')->toArray();
            if (empty($stockAwal)) {
                $stockAwal = [];
            }
            $stockAkhir = $queryStockAkhir->pluck('total_stock', 'product_id')->toArray();
            if (empty($stockAkhir)) {
                $stockAwal = [];
            }

        // Ambil daftar tahun untuk dropdown (ambil dari database)
        $years = $this->stocktransactionService->getTransactionYears();

        // Ambil daftar kategori untuk dropdown
        $categories = $this->categoryService->getAllCategories(); // Pastikan model Category ada
        return view('manager.report.index', compact('products', 'totalstokmasuk', 'totalstokkeluar','totalStockMasuk', 'totalStockKeluar', 'yearStart', 'yearEnd', 'monthStart', 'monthEnd', 'dateStart', 'dateEnd', 'years', 'categories', 'categoryId', 'stockAwal', 'stockAkhir'));
    }
}
