<?php

namespace App\Providers;


use App\Contracts\Services\TweetServiceContract;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
