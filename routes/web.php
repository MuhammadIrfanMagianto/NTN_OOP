<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Halaman Utama
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth (GET tampil form, POST proses login/register)
Route::get('/auth', [AuthController::class, 'index'])->name('auth');
Route::post('/auth', [AuthController::class, 'index'])->name('auth.process');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// CRUD Products (Web)
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
