<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TweetController;
use Illuminate\Support\Facades\Route;

Route::prefix('tweet')->group(function () {
    Route::get('/', [TweetController::class, 'list'])->name('tweet.list');
    Route::post('/', [TweetController::class, 'store'])->name('tweet.store');
});

Route::prefix('category')->group(function () {
    Route::get('/all', [CategoryController::class, 'all'])->name('category.all');
});

