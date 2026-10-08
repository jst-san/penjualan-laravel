<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\DetailTransaksiController;
use App\Http\Controllers\Api\TransaksiController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::resource('barang', BarangController::class);

Route::resource('transaksi', TransaksiController::class);

Route::resource('detail-transaksi', DetailTransaksiController::class);

Route::get('/dashboard', [AdminController::class, 'dashboardData']);

Route::post('/login', [UserController::class, 'login']);

Route::post('/register', [UserController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'index']);

    Route::post('/logout', [UserController::class, 'logout']);
});
