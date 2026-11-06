<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\DetailTransaksiController;
use App\Http\Controllers\Api\TransaksiController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', [UserController::class, 'current']);

    Route::post('/logout', [UserController::class, 'logout']);

    Route::middleware('role:superuser')->group(function () {
        Route::resource('users', UserController::class);

        Route::resource('barang', BarangController::class);

        Route::post('/transaksi', [TransaksiController::class, 'store']);

        Route::put('/transaksi/{transaksi}', [TransaksiController::class, 'update']);

        Route::delete('/transaksi/{transaksi}', [TransaksiController::class, 'destroy']);

        Route::resource('detail-transaksi', DetailTransaksiController::class);

        Route::get('/dashboard/best_seller', [DashboardController::class, 'best_seller']);

        Route::get('/dashboard/stats', [DashboardController::class, 'stats']);

        Route::get('/dashboard/low_stocks', [DashboardController::class, 'low_stocks']);

        Route::get('/dashboard/activity', [DashboardController::class, 'activity']);
    });

    Route::middleware('role:karyawan,superuser')->group(function() {
        Route::get('/transaksi', [TransaksiController::class, 'index']);

        Route::get('/transaksi/{id}', [TransaksiController::class, 'show']);
    });
});
