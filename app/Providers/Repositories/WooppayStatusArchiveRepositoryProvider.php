<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class WooppayStatusArchiveRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\WooppayStatusArchive\WooppayStatusArchiveRepositoryInterface::class,
            \App\Domain\Repositories\WooppayStatusArchive\WooppayStatusArchiveRepositoryEloquent::class,
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
