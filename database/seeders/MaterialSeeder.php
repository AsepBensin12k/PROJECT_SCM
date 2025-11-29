<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        $kalibaru = Supplier::where('name', 'Petani Kalibaru')->first();
        $silo = Supplier::where('name', 'Petani Silo')->first();
        $bondowoso = Supplier::where('name', 'Petani Bondowoso')->first();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Material::query()->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Material::insert([
            ['supplier_id' => $kalibaru->id, 'name' => 'Pisang Raja', 'unit' => 'kg', 'stock' => 120, 'price' => 8000, 'created_at' => now(), 'updated_at' => now()],
            ['supplier_id' => $kalibaru->id, 'name' => 'Gula', 'unit' => 'kg', 'stock' => 60, 'price' => 14000, 'created_at' => now(), 'updated_at' => now()],
            ['supplier_id' => $silo->id, 'name' => 'Minyak Goreng', 'unit' => 'liter', 'stock' => 80, 'price' => 15000, 'created_at' => now(), 'updated_at' => now()],
            ['supplier_id' => $bondowoso->id, 'name' => 'Coklat Bubuk', 'unit' => 'kg', 'stock' => 40, 'price' => 50000, 'created_at' => now(), 'updated_at' => now()],
            ['supplier_id' => $silo->id, 'name' => 'Tempe', 'unit' => 'kg', 'stock' => 100, 'price' => 10000, 'created_at' => now(), 'updated_at' => now()],
            ['supplier_id' => $bondowoso->id, 'name' => 'Kemasan Plastik', 'unit' => 'pak', 'stock' => 30, 'price' => 25000, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
