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
            ['BRG001', 'Mouse Wireless', 75000, 20],
            ['BRG002', 'Keyboard Mechanical', 120000, 15],
            ['BRG003', 'Flashdisk 32GB', 65000, 25],
            ['BRG004', 'Headset Gaming', 95000, 10],
            ['BRG005', 'Kabel Data Type-C', 35000, 30],
            ['BRG006', 'Mousepad Gaming RGB', 45000, 40],
            ['BRG007', 'Webcam Full HD 1080p', 250000, 8],
            ['BRG008', 'Speaker Bluetooth Portable', 180000, 12],
            ['BRG009', 'Powerbank 10000mAh', 150000, 18],
            ['BRG010', 'Charger Fast Charging 20W', 85000, 22],
            ['BRG011', 'Stand Laptop Aluminium', 110000, 15],
            ['BRG012', 'USB Hub 4 Port 3.0', 45000, 25],
            ['BRG013', 'Harddisk Eksternal 1TB', 750000, 7],
            ['BRG014', 'SSD NVMe 512GB', 550000, 10],
            ['BRG015', 'RAM DDR4 8GB PC2666', 320000, 12],
            ['BRG016', 'Monitor LED 24 Inch', 1450000, 5],
            ['BRG017', 'Cooling Pad Laptop 6 Fan', 90000, 14],
            ['BRG018', 'Card Reader USB 3.0', 30000, 35],
            ['BRG019', 'Kabel HDMI 2 Meter', 40000, 28],
            ['BRG020', 'Microphone Condenser USB', 210000, 9],
            ['BRG021', 'Ring Light 26cm + Tripod', 70000, 16],
            ['BRG022', 'Stylus Pen Universal', 50000, 20],
            ['BRG023', 'Earphone In-Ear 3.5mm', 45000, 30],
            ['BRG024', 'TWS Bluetooth Earphone', 165000, 15],
            ['BRG025', 'Converter HDMI to VGA', 35000, 22],
            ['BRG026', 'Sleeve Case Laptop 14 Inch', 85000, 18],
            ['BRG027', 'Cleaning Kit Laptop 5 in 1', 20000, 50],
            ['BRG028', 'Adapter OTG Type-C to USB', 15000, 45],
            ['BRG029', 'Pelindung Kabel Spiral', 5000, 100],
            ['BRG030', 'Tas Ransel Laptop Anti Air', 135000, 12],
        ];

        foreach ($barangs as $barang) {
            Barang::create([
                'kode_barang' => $barang[0],
                'nama_barang' => $barang[1],
                'harga'       => $barang[2],
                'stok'        => $barang[3],
            ]);
        }
    }
}
