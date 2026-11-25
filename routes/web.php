<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VerifikasiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::patch('/users/{user}/toggle', [UserController::class, 'toggle'])->name('users.toggle');
        Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.role');

        Route::resource('categories', CategoryController::class)->except(['show', 'create']);

        // Verifikasi barang
        Route::get('/verifikasi', [VerifikasiController::class, 'index'])->name('verifikasi.index');
        Route::patch('/verifikasi/{product}/setujui', [VerifikasiController::class, 'setujui'])->name('verifikasi.setujui');
        Route::patch('/verifikasi/{product}/tolak', [VerifikasiController::class, 'tolak'])->name('verifikasi.tolak');

        // Daftar barang (admin hanya melihat: daftar + detail)
        Route::resource('products', ProductController::class)->only(['index', 'show']);

        // Laporan transaksi
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    });

    Route::middleware('role:penjual')->prefix('penjual')->name('penjual.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'penjual'])->name('dashboard');
    });

    Route::middleware('role:user')->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'user'])->name('dashboard');
    });
});

require __DIR__ . '/auth.php';