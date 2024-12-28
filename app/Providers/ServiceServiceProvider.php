<?php

namespace App\Providers;


use App\Contracts\Services\CategoryServiceContract;
use App\Contracts\Services\TweetServiceContract;
use App\Services\CategoryService;
use App\Services\TweetService;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TweetServiceContract::class, TweetService::class);
        $this->app->bind(CategoryServiceContract::class, CategoryService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
