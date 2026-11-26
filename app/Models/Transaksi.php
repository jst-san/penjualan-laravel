<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['nomor_transaksi', 'tanggal', 'total'];

    public function detailTransaksis() {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id');    
    }
}