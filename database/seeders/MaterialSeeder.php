<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;
use App\Models\Supplier;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        $kalibaru = Supplier::where('name', 'Petani Kalibaru')->first();
        $silo = Supplier::where('name', 'Petani Silo')->first();

        Material::insert([
            ['supplier_id' => $kalibaru->id, 'name' => 'Pisang Raja', 'unit' => 'kg', 'stock' => 100, 'price' => 8000, 'created_at' => now(), 'updated_at' => now()],
            ['supplier_id' => $silo->id, 'name' => 'Minyak Goreng', 'unit' => 'liter', 'stock' => 50, 'price' => 14000, 'created_at' => now(), 'updated_at' => now()],
            ['supplier_id' => $kalibaru->id, 'name' => 'Kemasan Plastik', 'unit' => 'pak', 'stock' => 20, 'price' => 25000, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
