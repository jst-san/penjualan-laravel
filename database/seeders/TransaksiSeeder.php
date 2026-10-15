<?php

namespace Database\Seeders;

use App\Http\Controllers\Api\TransaksiController;
use App\Models\Barang;
use Illuminate\Database\Seeder;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransaksiSeeder extends Seeder
{
    public function run(): void
    {
        $controller = new TransaksiController();
        $barangs = Barang::all();

        if ($barangs->isEmpty()) {
            return;
        }

        $dates = [];
        for ($d = 0; $d < 15; $d++) {
            $dates[] = Carbon::now()->subDays(rand(0, 30));
        }

        for ($i = 0; $i < 55; $i++) {
            $selectedBarangs = $barangs->random(rand(1, 4));

            $items = [];
            foreach ($selectedBarangs as $barang) {
                if ($barang->stok > 0) {
                    $items[] = [
                        'id'  => $barang->id,
                        'qty' => rand(1, min(3, $barang->stok)),
                    ];
                }
            }

            if (empty($items)) {
                continue;
            }

            $baseDate = $dates[array_rand($dates)];
            $randomDate = $baseDate->copy()->setTime(rand(8, 20), rand(0, 59), rand(0, 59));

            Carbon::setTestNow($randomDate);

            $request = new Request();
            $request->merge(['items' => $items]);

            $response = $controller->store($request);

            if ($response->getStatusCode() !== 201) {
                $barangs = Barang::all();
            }
        }

        Carbon::setTestNow();
    }
}