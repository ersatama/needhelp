<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class CountryRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\Country\CountryRepositoryInterface::class,
            \App\Domain\Repositories\Country\CountryRepositoryEloquent::class,
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
