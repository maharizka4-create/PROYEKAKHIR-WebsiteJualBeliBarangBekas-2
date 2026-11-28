
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Penjual\PenjualOrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\VerifikasiController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CatalogController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/katalog', [CatalogController::class, 'index'])
    ->name('catalog.index');

Route::get('/katalog/{product}', [CatalogController::class, 'show'])
    ->name('catalog.show');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // ADMIN
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
        });

    // PENJUAL
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

    // PEMBELI
    Route::middleware('role:user')
        ->prefix('user')
        ->name('user.')
        ->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'user'])
                ->name('dashboard');
        });
});

require __DIR__ . '/auth.php';
