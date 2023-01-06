<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class TemporaryVariableRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\TemporaryVariable\TemporaryVariableRepositoryInterface::class,
            \App\Domain\Repositories\TemporaryVariable\TemporaryVariableRepositoryEloquent::class,
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
