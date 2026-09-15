<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
    $barangs = [
        ['BRG001','Mouse Wireless', 75000, 20],
        ['BRG002', 'Keyboard', 120000, 15],
        ['BRG003', 'Flashdisk 32GB', 65000, 25],
        ['BRG004', 'Headset', 95000, 10],
        ['BRG005', 'Kabel Data', 35000, 30]
    ];

    foreach($barangs as $barang) {
        Barang::create(['kode_barang'=>$barang[0],'nama_barang'=>$barang[1], 'harga'=>$barang[2],'stok'=>$barang[3]]);
    }
    }
}
