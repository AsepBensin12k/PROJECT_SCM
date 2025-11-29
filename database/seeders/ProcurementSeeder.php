<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Procurement;
use App\Models\Supplier;
use App\Models\Material;

class ProcurementSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada supplier & material dulu
        $supplier = Supplier::first() ?? Supplier::factory()->create();
        $material = Material::first() ?? Material::factory()->create([
            'name' => 'Tepung Terigu Premium',
            'unit' => 'kg',
            'stock' => 50,
            'price' => 12000,
            'supplier_id' => $supplier->id,
        ]);

        Procurement::create([
            'material_id' => $material->id,
            'supplier_id' => $supplier->id,
            'tanggal_datang' => now()->addDays(3),
            'qty' => 100,
            'total_harga' => 12000 * 100,
            'status' => 'diproses',
        ]);

        Procurement::create([
            'material_id' => $material->id,
            'supplier_id' => $supplier->id,
            'tanggal_datang' => now(),
            'qty' => 80,
            'total_harga' => 960000,
            'status' => 'sampai',
        ]);
    }
}
