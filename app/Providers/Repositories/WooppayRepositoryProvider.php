<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class WooppayRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\Wooppay\WooppayRepositoryInterface::class,
            \App\Domain\Repositories\Wooppay\WooppayRepositoryEloquent::class,
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
