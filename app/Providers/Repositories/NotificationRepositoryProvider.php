<?php

namespace App\Providers\Repositories;

use App\Models\Notification;
use App\Observers\Notification\NotificationObserver;
use Illuminate\Support\ServiceProvider;

class NotificationRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\Notification\NotificationRepositoryInterface::class,
            \App\Domain\Repositories\Notification\NotificationRepositoryEloquent::class,
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        Notification::observe(NotificationObserver::class);
    }
}
