<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class CityRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\City\CityRepositoryInterface::class,
            \App\Domain\Repositories\City\CityRepositoryEloquent::class,
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
