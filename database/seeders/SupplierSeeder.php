<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::insert([
            [
                'name' => 'Petani Kalibaru',
                'origin' => 'Kalibaru, Banyuwangi',
                'contact' => '081234567890',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Petani Silo',
                'origin' => 'Silo, Jember',
                'contact' => '081298765432',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Petani Bondowoso',
                'origin' => 'Bondowoso, Jawa Timur',
                'contact' => '081345678901',
                'status' => 'non-aktif',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Petani Situbondo',
                'origin' => 'Situbondo, Jawa Timur',
                'contact' => '081456789012',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Petani Probolinggo',
                'origin' => 'Probolinggo, Jawa Timur',
                'contact' => '081567890123',
                'status' => 'non-aktif',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}