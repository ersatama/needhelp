<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class NotificationHistoryRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\NotificationHistory\NotificationHistoryRepositoryInterface::class,
            \App\Domain\Repositories\NotificationHistory\NotificationHistoryRepositoryEloquent::class,
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
