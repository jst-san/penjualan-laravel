<?php

use App\Http\Controllers\Api\DetailTransaksiController;
use App\Http\Controllers\Api\TransaksiController;
use App\Http\Controllers\Api\BarangController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/transaksi', [TransaksiController::class, 'index']);

Route::post('/transaksi', [TransaksiController::class, 'store']);

Route::delete('/transaksi/{id}', [TransaksiController::class, 'destroy']);

Route::get('/barang', [BarangController::class, 'index']);