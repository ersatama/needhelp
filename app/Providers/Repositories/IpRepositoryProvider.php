<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class IpRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\Ip\IpRepositoryInterface::class,
            \App\Domain\Repositories\Ip\IpRepositoryEloquent::class,
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
