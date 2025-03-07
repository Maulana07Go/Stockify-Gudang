<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\SupplierRepositoryInterface;
use App\Repositories\Eloquent\SupplierRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Interfaces\UserActivityRepositoryInterface;
use App\Repositories\Eloquent\UserActivityRepository;
use App\Repositories\Interfaces\StockTransactionRepositoryInterface;
use App\Repositories\Eloquent\StockTransactionRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(SupplierRepositoryInterface::class, SupplierRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserActivityRepositoryInterface::class, UserActivityRepository::class);
        $this->app->bind(StockTransactionRepositoryInterface::class, StockTransactionRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
