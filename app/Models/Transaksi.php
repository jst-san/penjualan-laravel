<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = ['nomor_transaksi', 'tanggal', 'total'];

    public function detailTransaksi() {
        return $this->hasMany(DetailTransaksis::class, 'transaksi_id');    
    }
}