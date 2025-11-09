<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        Supplier::insert([
            ['name' => 'Petani Kalibaru', 'origin' => 'Kalibaru, Banyuwangi', 'contact' => '081234567890', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Petani Silo', 'origin' => 'Silo, Jember', 'contact' => '081298765432', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
