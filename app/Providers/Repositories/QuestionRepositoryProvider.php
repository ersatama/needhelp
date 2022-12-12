<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class QuestionRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\Question\QuestionRepositoryInterface::class,
            \App\Domain\Repositories\Question\QuestionRepositoryEloquent::class,
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
