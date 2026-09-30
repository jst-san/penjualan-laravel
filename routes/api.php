<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\DetailTransaksiController;
use App\Http\Controllers\Api\TransaksiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::resource('barang', BarangController::class);

Route::resource('transaksi', TransaksiController::class);

Route::resource('detail-transaksi', DetailTransaksiController::class);

Route::get('/dashboard', [AdminController::class, 'dashboardData']);