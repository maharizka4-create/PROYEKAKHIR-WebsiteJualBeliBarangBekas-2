<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\OrderController;

use App\Http\Controllers\Penjual\PenjualOrderController;

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\VerifikasiController;
use App\Http\Controllers\Admin\PembayaranController;


// ========================================
// HALAMAN UTAMA
// ========================================

Route::get('/', function () {
    return view('welcome');
})->name('home');


// ========================================
// KATALOG PUBLIK
// ========================================

Route::get('/katalog', [CatalogController::class, 'index'])
    ->name('catalog.index');

Route::get('/katalog/{product}', [CatalogController::class, 'show'])
    ->name('catalog.show');


// ========================================
// PENGGUNA LOGIN
// ========================================

Route::middleware('auth')->group(function () {

    // DASHBOARD UTAMA
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    // PROFIL
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    // ========================================
    // ADMIN (RIKA)
    // ========================================

    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'admin'])
                ->name('dashboard');

            Route::get('/users', [UserController::class, 'index'])
                ->name('users.index');

            Route::patch('/users/{user}/toggle', [UserController::class, 'toggle'])
                ->name('users.toggle');

            Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])
                ->name('users.role');

            Route::resource('categories', CategoryController::class)
                ->except(['show', 'create']);

            Route::get('/verifikasi', [VerifikasiController::class, 'index'])
                ->name('verifikasi.index');

            Route::patch('/verifikasi/{product}/setujui', [VerifikasiController::class, 'setujui'])
                ->name('verifikasi.setujui');

            Route::patch('/verifikasi/{product}/tolak', [VerifikasiController::class, 'tolak'])
                ->name('verifikasi.tolak');

            Route::resource('products', AdminProductController::class)
                ->only(['index', 'show']);

            Route::get('/laporan', [LaporanController::class, 'index'])
                ->name('laporan.index');

            // Verifikasi pembayaran
            Route::get('/pembayaran', [PembayaranController::class, 'index'])
                ->name('pembayaran.index');

            Route::patch('/pembayaran/{order}/setujui', [PembayaranController::class, 'setujui'])
                ->name('pembayaran.setujui');

            Route::patch('/pembayaran/{order}/tolak', [PembayaranController::class, 'tolak'])
                ->name('pembayaran.tolak');
        });


    // ========================================
    // PENJUAL (JULIAN)
    // ========================================

    Route::middleware('role:penjual')
        ->prefix('penjual')
        ->name('penjual.')
        ->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'penjual'])
                ->name('dashboard');

            Route::resource('products', ProductController::class);

            Route::get('/orders', [PenjualOrderController::class, 'index'])
                ->name('orders.index');

            Route::patch('/orders/{order}/kirim', [PenjualOrderController::class, 'kirim'])
                ->name('orders.kirim');
        });


    // ========================================
    // PEMBELI (USER)
    // ========================================

    Route::middleware('role:user')
        ->prefix('user')
        ->name('user.')
        ->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'user'])
                ->name('dashboard');

            // CHECKOUT
            Route::get('/checkout/{product}', [OrderController::class, 'create'])
                ->name('checkout');

            Route::post('/checkout/{product}', [OrderController::class, 'store'])
                ->name('checkout.store');

            // RIWAYAT PEMBELIAN
            Route::get('/pesanan', [OrderController::class, 'index'])
                ->name('orders.index');

            // UPLOAD BUKTI TRANSFER
            Route::post('/pesanan/{order}/bukti-pembayaran', [OrderController::class, 'uploadBukti'])
                ->name('orders.bukti');

            // KONFIRMASI BARANG DITERIMA
            Route::patch('/pesanan/{order}/diterima', [OrderController::class, 'konfirmasiDiterima'])
                ->name('orders.diterima');
        });

});


// ========================================
// AUTHENTICATION
// ========================================

require __DIR__ . '/auth.php';