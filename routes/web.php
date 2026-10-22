<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:6,1');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Superadmin Only
    |--------------------------------------------------------------------------
    | The transaksi create/store routes are registered before the shared
    | /transaksis/{transaksi} show route so that "create" is not captured as
    | a route model binding.
    */
    Route::middleware('role:superadmin')->group(function () {
        Route::get('/transaksis/create', [TransaksiController::class, 'create'])->name('transaksis.create');
        Route::post('/transaksis', [TransaksiController::class, 'store'])->name('transaksis.store');
        Route::get('/transaksis/{transaksi}/edit', [TransaksiController::class, 'edit'])->name('transaksis.edit');
        Route::put('/transaksis/{transaksi}', [TransaksiController::class, 'update'])->name('transaksis.update');
        Route::delete('/transaksis/{transaksi}', [TransaksiController::class, 'destroy'])->name('transaksis.destroy');

        Route::resource('users', UserController::class)->except('show');
        Route::resource('barangs', BarangController::class)->except('show');
    });

    /*
    |--------------------------------------------------------------------------
    | Shared Access (Superadmin & Karyawan)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:superadmin,karyawan')->group(function () {
        Route::get('/transaksis', [TransaksiController::class, 'index'])->name('transaksis.index');
        Route::get('/transaksis/{transaksi}', [TransaksiController::class, 'show'])->name('transaksis.show');
    });
});
