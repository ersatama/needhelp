<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class PhoneCodeRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\PhoneCode\PhoneCodeRepositoryInterface::class,
            \App\Domain\Repositories\PhoneCode\PhoneCodeRepositoryEloquent::class
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
