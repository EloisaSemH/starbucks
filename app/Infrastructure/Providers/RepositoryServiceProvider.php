<?php

namespace App\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use App\Infrastructure\Persistence\Contracts\{ProductRepository, ExtraRepository, OrderRepository};
use App\Infrastructure\Persistence\Eloquent\Repositories\{
    EloquentProductRepository,
    EloquentExtraRepository,
    EloquentOrderRepository,
};

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepository::class, EloquentProductRepository::class);
        $this->app->bind(ExtraRepository::class, EloquentExtraRepository::class);
        $this->app->bind(OrderRepository::class, EloquentOrderRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
