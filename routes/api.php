<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::apiResource('products', ProductController::class)->names([
    'index'   => 'api.products',
    'store'   => 'api.products.store',
    'show'    => 'api.products.show',
    'update'  => 'api.products.update',
    'destroy' => 'api.products.destroy',
]);
