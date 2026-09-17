<?php

use Illuminate\Support\Facades\Route;


Route::livewire("/", "home");

Route::livewire("/barang", "barang");

Route::livewire("/transaksi", "transaksi");

Route::livewire("/transaksi/create", "transaksi.create");

Route::livewire("/transaksi/{id}", "transaksi.details");