<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\TransaksiCreatePageController;
use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    $transaksi_count = Transaksi::count();
    $transaksi_total = Transaksi::sum('total');
    $barang_count = Barang::count();
    return view('index', ['transaksi_count' => $transaksi_count, 'transaksi_total' => $transaksi_total, 'barang_count' => $barang_count]);
});

Route::get('/barang', [BarangController::class, 'index']);

Route::get('/barang/create', [BarangController::class, 'create']);

Route::get('/barang/{barang}/edit', [BarangController::class, 'edit']);

Route::post('/barang', [BarangController::class, 'store']);

Route::put('/barang/{id}', [BarangController::class, 'update']);

Route::delete('/barang/{id}', [BarangController::class, 'destroy']);

Route::get('/transaksi', [TransaksiController::class, 'index']);

Route::get('/transaksi/create', [TransaksiController::class, 'create']);

Route::get('/transaksi/{id}', [TransaksiController::class, 'show']);