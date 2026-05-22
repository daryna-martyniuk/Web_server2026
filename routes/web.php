<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestTestController;
use App\Http\Controllers\Api\Blog\PostController;

Route::prefix('blog')->group(function () {
    Route::resource('posts', PostController::class)->names('blog.posts');
});

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::apiResource('rest', RestTestController::class)->names('restTest');
