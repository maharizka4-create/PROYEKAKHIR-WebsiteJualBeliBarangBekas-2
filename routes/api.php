<?php

use App\Http\Controllers\Api\Admin\ProductController as ApiProductController;
use App\Http\Controllers\Api\Admin\StatistikController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

// Publik: login untuk mendapatkan token
Route::post('/login', [AuthController::class, 'login']);

// Harus login (token atau sesi dari halaman web)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Khusus admin
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/statistik', [StatistikController::class, 'index']);
        Route::get('/products', [ApiProductController::class, 'index']);
        Route::get('/products/{product}', [ApiProductController::class, 'show']);
    });
});