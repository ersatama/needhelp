<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class RegionRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\Region\RegionRepositoryInterface::class,
            \App\Domain\Repositories\Region\RegionRepositoryEloquent::class,
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
