<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SupplierController as AdminSupplierController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\StockTransactionController as AdminStockTransactionController;
use App\Http\Controllers\StockMinimumController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StockOpnameController as AdminStockOpnameController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\ProductAttributeController as AdminProductAttributeController;
use App\Http\Controllers\Manager\ProductController as ManagerProductController;
use App\Http\Controllers\Manager\StockTransactionController as ManagerStockTransactionController;
use App\Http\Controllers\Manager\StockOpnameController as ManagerStockOpnameController;
use App\Http\Controllers\Manager\SupplierController as ManagerSupplierController;
use App\Http\Controllers\Manager\LowStockController;
use App\Http\Controllers\Manager\InTodayController;
use App\Http\Controllers\Manager\OutTodayController;
use App\Http\Controllers\Manager\ReportController as ManagerReportController;
use App\Http\Controllers\Manager\ProfileController as ManagerProfileController;
use App\Http\Controllers\Staff\StockTransactionController as StaffStockTransactionController;
use App\Http\Controllers\Staff\InConfirmStockTransactionController;
use App\Http\Controllers\Staff\OutConfirmStockTransactionController;
use App\Http\Controllers\Staff\ProfileController as StaffProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/stockify', [\App\Http\Controllers\LandingController::class, 'index'])->name('landing')->middleware('guest');

Route::get('/register', [\App\Http\Controllers\RegisterController::class, 'create'])->name('register')->middleware('guest');
Route::post('/register', [\App\Http\Controllers\RegisterController::class, 'store'])->name('register')->middleware('guest');
Route::get('/login', [\App\Http\Controllers\LoginController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [\App\Http\Controllers\LoginController::class, 'authenticate'])->name('login')->middleware('guest');

Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/login');
})->name('logout')->middleware('auth');
Route::view('/home', 'home')->name('home')->middleware('auth');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard.index');
});

Route::middleware(['auth', 'staff'])->group(function () {
    Route::get('/staff/dashboard', [StaffController::class, 'index'])->name('staff.dashboard.index');
});

Route::middleware(['auth', 'manager'])->group(function () {
    Route::get('/manager/dashboard', [ManagerController::class, 'index'])->name('manager.dashboard.index');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::resource('product', AdminProductController::class)->names([
        'index' => 'admin.product.index',
        'create' => 'admin.product.create',
        'store' => 'admin.product.store',
        'show' => 'admin.product.show',
        'edit' => 'admin.product.edit',
        'update' => 'admin.product.update',
        'destroy' => 'admin.product.destroy',
    ]);
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/product', [AdminProductController::class, 'index'])->name('admin.product.index');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::resource('category', CategoryController::class)->names([
        'index' => 'admin.product.category.index',
        'create' => 'admin.product.category.create',
        'store' => 'admin.product.category.store',
        'edit' => 'admin.product.category.edit',
        'update' => 'admin.product.category.update',
        'destroy' => 'admin.product.category.destroy',
    ]);
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::resource('supplier', AdminSupplierController::class)->names([
        'index' => 'admin.supplier.index',
        'create' => 'admin.supplier.create',
        'store' => 'admin.supplier.store',
        'edit' => 'admin.supplier.edit',
        'update' => 'admin.supplier.update',
        'destroy' => 'admin.supplier.destroy',
    ]);
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/supplier', [AdminSupplierController::class, 'index'])->name('admin.supplier.index');
    Route::get('/category', [CategoryController::class, 'index'])->name('admin.product.category.index');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('user', UserController::class);
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/stock', [AdminStockTransactionController::class, 'index'])->name('admin.stock.index');
    Route::get('/opname', [AdminStockOpnameController::class, 'index'])->name('admin.stock.opname.index');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/stock/minimum', [StockMinimumController::class, 'index'])->name('admin.stock.minimum.index');
    Route::get('/stock/minimum/{id}/edit', [StockMinimumController::class, 'edit'])->name('admin.stock.minimum.edit');
    Route::put('/stock/minimum/{id}', [StockMinimumController::class, 'update'])->name('admin.stock.minimum.update');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/settings', [SettingController::class, 'index'])->name('admin.setting.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('admin.setting.update');
    Route::get('/report', [AdminReportController::class, 'index'])->name('admin.report.index');
    Route::get('/export-stock-csv', [AdminReportController::class, 'exportCsv'])->name('admin.report.exportCsv');
    Route::post('/import-stock-csv', [AdminReportController::class, 'importCsv'])->name('admin.report.importCsv');
    Route::get('/export-produck-csv', [AdminProductController::class, 'exportCsv'])->name('admin.product.exportCsv');
    Route::post('/import-produck-csv', [AdminProductController::class, 'importCsv'])->name('admin.product.importCsv');
    Route::get('/profile', [AdminProfileController::class, 'index'])->name('admin.profile.index');
    Route::post('/profile/update', [AdminProfileController::class, 'update'])->name('admin.profile.update');
    Route::get('/products/{product}/attributes/create', [AdminProductAttributeController::class, 'create'])->name('admin.product.attribute.create');
    Route::post('/products/{product}/attributes', [AdminProductAttributeController::class, 'store'])->name('admin.product.attribute.store');
    Route::get('/attributes/{attribute}/edit', [AdminProductAttributeController::class, 'edit'])->name('admin.product.attribute.edit');
    Route::put('/attributes/{attribute}', [AdminProductAttributeController::class, 'update'])->name('admin.product.attribute.update');
});

Route::middleware(['auth', 'manager'])->prefix('manager')->group(function () {
    Route::get('/product', [ManagerProductController::class, 'index'])->name('manager.product.index');
    Route::get('/product/{id}', [ManagerProductController::class, 'show'])->name('manager.product.show');
    Route::get('/stock', [ManagerStockTransactionController::class, 'index'])->name('manager.stock.index');
    Route::resource('stock', ManagerStockTransactionController::class)->names([
        'index' => 'manager.stock.index',
        'create' => 'manager.stock.create',
        'store' => 'manager.stock.store',
        'show' => 'manager.stock.show',
    ]);
    Route::get('/opname', [ManagerStockOpnameController::class, 'index'])->name('manager.stock.opname.index');
    Route::get('/create', [ManagerStockOpnameController::class, 'create'])->name('manager.stock.opname.create');
    Route::post('/store', [ManagerStockOpnameController::class, 'store'])->name('manager.stock.opname.store');
    Route::get('/supplier', [ManagerSupplierController::class, 'index'])->name('manager.supplier.index');
    Route::get('/lowstock', [LowStockController::class, 'index'])->name('manager.dashboard.lowstock.index');
    Route::get('/intoday', [InTodayController::class, 'index'])->name('manager.dashboard.intoday.index');
    Route::get('/outtoday', [OutTodayController::class, 'index'])->name('manager.dashboard.outtoday.index');
    Route::get('/report', [ManagerReportController::class, 'index'])->name('manager.report.index');
    Route::get('/profile', [ManagerProfileController::class, 'index'])->name('manager.profile.index');
    Route::post('/profile/update', [ManagerProfileController::class, 'update'])->name('manager.profile.update');
});

Route::middleware(['auth', 'staff'])->prefix('staff')->group(function () {
    Route::get('/stock', [StaffStockTransactionController::class, 'index'])->name('staff.stock.index');
    Route::resource('stock', StaffStockTransactionController::class)->names([
        'index' => 'staff.stock.index',
        'show' => 'staff.stock.show',
    ]);
    Route::get('/inconfirm', [InConfirmStockTransactionController::class, 'index'])->name('staff.stock.inconfirm.index');
    Route::get('/stock/inconfirm/{id}/edit', [InConfirmStockTransactionController::class, 'edit'])->name('staff.stock.inconfirm.edit');
    Route::put('/stock/inconfirm/{id}', [InConfirmStockTransactionController::class, 'update'])->name('staff.stock.inconfirm.update');
    Route::get('/outconfirm', [OutConfirmStockTransactionController::class, 'index'])->name('staff.stock.outconfirm.index');
    Route::get('/stock/outconfirm/{id}/edit', [OutConfirmStockTransactionController::class, 'edit'])->name('staff.stock.outconfirm.edit');
    Route::put('/stock/outconfirm/{id}', [OutConfirmStockTransactionController::class, 'update'])->name('staff.stock.outconfirm.update');
    Route::get('/profile', [StaffProfileController::class, 'index'])->name('staff.profile.index');
    Route::post('/profile/update', [StaffProfileController::class, 'update'])->name('staff.profile.update');
});