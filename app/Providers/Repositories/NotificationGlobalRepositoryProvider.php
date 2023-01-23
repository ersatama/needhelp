<?php

namespace App\Providers\Repositories;

use App\Models\NotificationGlobal;
use App\Observers\NotificationGlobal\NotificationGlobalObserver;
use Illuminate\Support\ServiceProvider;

class NotificationGlobalRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\NotificationGlobal\NotificationGlobalRepositoryInterface::class,
            \App\Domain\Repositories\NotificationGlobal\NotificationGlobalRepositoryEloquent::class,
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        NotificationGlobal::observe(NotificationGlobalObserver::class);
    }
}
