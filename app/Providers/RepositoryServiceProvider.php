<?php

namespace App\Providers;

use App\Contracts\Repositories\TweetRepositoryContract;
use App\Repositories\TweetRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TweetRepositoryContract::class, TweetRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
