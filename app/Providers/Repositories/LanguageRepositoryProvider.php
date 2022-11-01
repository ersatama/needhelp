<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class LanguageRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\Language\LanguageRepositoryInterface::class,
            \App\Domain\Repositories\Language\LanguageRepositoryEloquent::class
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
