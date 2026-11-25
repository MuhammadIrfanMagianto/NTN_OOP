<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('jwt.verify')->group(function () {
    Route::get('/me', [AuthController::class, 'me'])->name('api.me');
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');

    Route::apiResource('products', ProductController::class)->names([
        'index'   => 'api.products',
        'store'   => 'api.products.store',
        'show'    => 'api.products.show',
        'update'  => 'api.products.update',
        'destroy' => 'api.products.destroy',
    ]);
});
