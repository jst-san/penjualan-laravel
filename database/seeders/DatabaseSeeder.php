<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'superuser@rpl.com'],
            [
                'name' => 'Superuser',
                'password' => Hash::make('password'),
                'role' => 'superuser',
            ],
        );

        User::updateOrCreate(
            ['email' => 'karyawan@rpl.com'],
            [
                'name' => 'Karyawan',
                'password' => Hash::make('password'),
                'role' => 'karyawan',
            ],
        );

        (new BarangSeeder)->run();
        (new TransaksiSeeder)->run();
    }
}
