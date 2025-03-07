<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Models\StockTransaction;
use App\Models\Category;

class ReportController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category_id');
        $products = $this->productService->getFilteredProducts($search, $categoryId);
        $totalstokmasuk = StockTransaction::whereIn('type', ['Masuk'])->whereIn('status', ['Diterima'])->sum('quantity');
        $totalstokkeluar = StockTransaction::whereIn('type', ['Keluar'])->whereIn('status', ['Dikeluarkan'])->sum('quantity');
        // Ambil input dari form dropdown
        $yearStart = $request->input('year_start');
        $yearEnd = $request->input('year_end');
        $monthStart = $request->input('month_start');
        $monthEnd = $request->input('month_end');
        $dateStart = $request->input('date_start');
        $dateEnd = $request->input('date_end');
        $firstDay = StockTransaction::min('date') ?? now()->format('Y-m-d'); // Tanggal transaksi pertama
        $lastDay = StockTransaction::max('date') ?? now()->format('Y-m-d');  // Tanggal transaksi terakhir

        // Query untuk filter berdasarkan input
        $queryStockMasuk = StockTransaction::whereIn('type', ['Masuk'])
            ->whereIn('status', ['Diterima'])
            ->whereHas('product', function ($q) use ($categoryId) {
                if ($categoryId) {
                    $q->where('category_id', $categoryId);
                }
            })
            ->selectRaw('product_id, SUM(quantity) as total_quantity')
            ->groupBy('product_id');

        $queryStockKeluar = StockTransaction::whereIn('type', ['Keluar'])
            ->whereIn('status', ['Dikeluarkan'])
            ->whereHas('product', function ($q) use ($categoryId) {
                if ($categoryId) {
                    $q->where('category_id', $categoryId);
                }
            })
            ->selectRaw('product_id, SUM(quantity) as total_quantity')
            ->groupBy('product_id');

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

        $queryStockAwal = StockTransaction::whereIn('type', ['Masuk','Keluar'])
            ->whereIn('status', ['Diterima','Dikeluarkan'])
            ->whereHas('product', function ($q) use ($categoryId) {
                if ($categoryId) {
                    $q->where('category_id', $categoryId);
                }
            })
            ->whereDate('date', '<', $firstDay)
            ->selectRaw('product_id, SUM(CASE WHEN type = "Masuk" THEN quantity ELSE -quantity END) as total_stock')
            ->groupBy('product_id');

        $queryStockAkhir = StockTransaction::whereIn('type', ['Masuk', 'Keluar'])
            ->whereIn('status', ['Diterima', 'Dikeluarkan'])
            ->whereHas('product', function ($q) use ($categoryId) {
                if ($categoryId) {
                    $q->where('category_id', $categoryId);
                }
            })
            ->whereDate('date', '<=', $lastDay)
            ->selectRaw('product_id, SUM(CASE WHEN type = "Masuk" THEN quantity ELSE -quantity END) as total_stock')
            ->groupBy('product_id');

            $stockAwal = $queryStockAwal->pluck('total_stock', 'product_id')->toArray();
            if (empty($stockAwal)) {
                $stockAwal = [];
            }
            $stockAkhir = $queryStockAkhir->pluck('total_stock', 'product_id')->toArray();
            if (empty($stockAkhir)) {
                $stockAwal = [];
            }

        // Ambil daftar tahun untuk dropdown (ambil dari database)
        $years = StockTransaction::selectRaw('YEAR(date) as year')->distinct()->pluck('year');

        // Ambil daftar kategori untuk dropdown
        $categories = Category::all(); // Pastikan model Category ada
        return view('manager.report.index', compact('products', 'totalstokmasuk', 'totalstokkeluar','totalStockMasuk', 'totalStockKeluar', 'yearStart', 'yearEnd', 'monthStart', 'monthEnd', 'dateStart', 'dateEnd', 'years', 'categories', 'categoryId', 'stockAwal', 'stockAkhir'));
    }
}
