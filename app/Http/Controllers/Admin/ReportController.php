<?php

namespace App\Http\Controllers\Admin;

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
        return view('admin.report.index', compact('products', 'totalstokmasuk', 'totalstokkeluar','totalStockMasuk', 'totalStockKeluar', 'yearStart', 'yearEnd', 'monthStart', 'monthEnd', 'dateStart', 'dateEnd', 'years', 'categories', 'categoryId', 'stockAwal', 'stockAkhir'));
    }

    public function exportCsv()
    {
        $fileName = 'stock_report.csv';
        $stocks = $this->stocktransactionService->getAllStockTransactions();

        $headers = [
            "Content-Type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($stocks) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Product ID', 'Quantity', 'Type', 'Status', 'Date']);

            foreach ($stocks as $stock) {
                fputcsv($file, [
                    $stock->id,
                    $stock->product_id,
                    $stock->quantity,
                    $stock->type,
                    $stock->status,
                    $stock->date
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importCsv(Request $request)
    {
        $file = $request->file('csv_file');

        if (!$file) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        $handle = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($handle, 1000, ","); // Ambil header CSV

        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            $this->stocktransactionService->createStockTransaction([
                "product_id" => $data[1],
                "user_id" => $data[2],
                "type" => $data[3],
                "quantity" => $data[4],
                "date" => $data[5],
                "status" => $data[6],
                "notes" => $data[7],
            ]);
        }

        fclose($handle);

        return back()->with('success', 'Data berhasil diimport.');
    }

}
