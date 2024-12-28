<?php

namespace App\Providers;

use App\Contracts\Repositories\CategoryRepositoryContract;
use App\Contracts\Repositories\TweetRepositoryContract;
use App\Repositories\CategoryRepository;
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
        $this->app->bind(CategoryRepositoryContract::class, CategoryRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
