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
    Route::resource('users', UserController::class);

    Route::get('/user', [UserController::class, 'current']);

    Route::post('/logout', [UserController::class, 'logout']);
    
    Route::resource('barang', BarangController::class);
    
    Route::resource('transaksi', TransaksiController::class);
    
    Route::resource('detail-transaksi', DetailTransaksiController::class);

    Route::get('/dashboard/best_seller', [DashboardController::class, 'best_seller']);

    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);

    Route::get('/dashboard/low_stocks', [DashboardController::class, 'low_stocks']);

    Route::get('/dashboard/activity', [DashboardController::class, 'activity']);
});
