<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class NotificationEventRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\NotificationEvent\NotificationEventRepositoryInterface::class,
            \App\Domain\Repositories\NotificationEvent\NotificationEventRepositoryEloquent::class,
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
