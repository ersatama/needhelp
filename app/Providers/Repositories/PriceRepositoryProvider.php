<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class PriceRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\Price\PriceRepositoryInterface::class,
            \App\Domain\Repositories\Price\PriceRepositoryEloquent::class,
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
