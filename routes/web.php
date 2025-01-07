<?php

use App\Http\Controllers\TweetController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TweetController::class, 'index'])->name('tweet.index');
Route::get('/list', [TweetController::class, 'list'])->name('tweet.list');
Route::post('/store', [TweetController::class, 'store'])->name('tweet.store');
