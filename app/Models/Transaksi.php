<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = ['nomor_transaksi', 'tanggal', 'total'];

    public function detailTransaksis() {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id');    
    }
}