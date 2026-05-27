<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestTestController;
use App\Http\Controllers\Api\Blog\PostController;
use App\Http\Controllers\DiggingDeeperController;

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

Route::group(['prefix' => 'digging_deeper'], function () {

    Route::get('collections', [DiggingDeeperController::class, 'collections'])

        ->name('digging_deeper.collections');

});

Route::apiResource('rest', RestTestController::class)->names('restTest');

