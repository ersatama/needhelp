<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class PaymentRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\Payment\PaymentRepositoryInterface::class,
            \App\Domain\Repositories\Payment\PaymentRepositoryEloquent::class
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
