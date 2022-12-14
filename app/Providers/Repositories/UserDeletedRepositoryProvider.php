<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class UserDeletedRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\UserDeleted\UserDeletedRepositoryInterface::class,
            \App\Domain\Repositories\UserDeleted\UserDeletedRepositoryEloquent::class,
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
