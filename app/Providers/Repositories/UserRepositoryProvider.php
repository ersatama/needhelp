<?php

namespace App\Providers\Repositories;

use App\Models\User;
use App\Observers\User\UserObserver;
use Illuminate\Support\ServiceProvider;

class UserRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\User\UserRepositoryInterface::class,
            \App\Domain\Repositories\User\UserRepositoryEloquent::class,
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
    }
}
