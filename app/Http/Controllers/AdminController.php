<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\UserActivity;
use App\Models\User;
use App\Services\UserActivityService;
use Carbon\Carbon;

class AdminController extends Controller
{
    protected $useractivityService;

    public function __construct(UserActivityService $useractivityService)
    {
        $this->useractivityService = $useractivityService;
    }

    public function index(Request $request)
    
    {
        $transactionin = StockTransaction::whereIn('type', ['Masuk'])->whereIn('status',['Diterima'])->count();
        $transactionout = StockTransaction::whereIn('type', ['Keluar'])->whereIn('status',['Dikeluarkan'])->count(); 
        $totalProducts = Product::count();
        $intoday = StockTransaction::whereIn('type', ['Masuk'])->whereIn('status',['Diterima'])->whereDate('date',now())->count();
        $inthismonth = StockTransaction::whereIn('type', ['Masuk'])->whereIn('status', ['Diterima'])->whereMonth('date', Carbon::now()->month)->whereYear('date', Carbon::now()->year)->count();
        $outtoday = StockTransaction::whereIn('type', ['Keluar'])->whereIn('status',['Dikeluarkan'])->whereDate('date',now())->count();
        $outthismonth = StockTransaction::whereIn('type', ['Keluar'])->whereIn('status', ['Dikeluarkan'])->whereMonth('date', Carbon::now()->month)->whereYear('date', Carbon::now()->year)->count();
        $search = $request->input('search');
        $useractivities = $this->useractivityService->getFilteredUserActivity($search);
        $usernames = User::whereIn('id', $useractivities->pluck('user_id'))->get();

        $stockData = Product::with('category')
            ->selectRaw('category_id, SUM(stock) as total_stock')
            ->groupBy('category_id')
            ->get();

        // Konversi ID kategori menjadi nama kategori
        $stockData->each(function ($item) {
            $item->category_name = optional($item->category)->name;
        });

        // Mengambil data pergerakan stok (barang masuk dan keluar) dalam 30 hari terakhir
        $stockMovement = StockTransaction::selectRaw(
            'DATE(date) as date, 
             SUM(CASE WHEN type = "Masuk" THEN quantity ELSE 0 END) as stock_in,
             SUM(CASE WHEN type = "Keluar" THEN quantity ELSE 0 END) as stock_out'
        )
        ->where('date', '>=', now()->subDays(30))
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        return view('admin.dashboard.index', compact('transactionin', 'transactionout', 'totalProducts', 'useractivities', 'usernames', 'intoday', 'outtoday', 'inthismonth','outthismonth', 'stockData', 'stockMovement'));
    }
}
