<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// index.php        -> /
Route::get('/', [HomeController::class, 'index'])->name('home');

// auth.php         -> /auth (GET tampil form, POST proses login/register)
Route::match(['get', 'post'], '/auth', [AuthController::class, 'index'])->name('auth');

// auth.php?logout=1 -> /logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// products.php     -> /products
Route::get('/products', [ProductController::class, 'index'])->name('products');

// api_products.php -> /api/products  (JSON, wajib login via session)
Route::get('/api/products', [ProductController::class, 'api'])->name('api.products');
