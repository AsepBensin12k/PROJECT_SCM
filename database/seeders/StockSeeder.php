<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Stock, Material, Product};
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan foreign key sementara
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Stock::query()->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $pisang = Material::where('name', 'Pisang Raja')->first();
        $minyak = Material::where('name', 'Minyak Goreng')->first();
        $gula = Material::where('name', 'Gula')->first();
        $tempe = Material::where('name', 'Tempe')->first();

        $produkPisang = Product::where('name', 'Keripik Pisang ROJEMBER 100gr')->first();
        $produkTempe = Product::where('name', 'Keripik Tempe ROJEMBER')->first();

        // Cegah error kalau ada data null
        if ($pisang) {
            Stock::create(['material_id' => $pisang->id, 'quantity' => 100, 'type' => 'bahan']);
        }
        if ($minyak) {
            Stock::create(['material_id' => $minyak->id, 'quantity' => 80, 'type' => 'bahan']);
        }
        if ($gula) {
            Stock::create(['material_id' => $gula->id, 'quantity' => 60, 'type' => 'bahan']);
        }
        if ($tempe) {
            Stock::create(['material_id' => $tempe->id, 'quantity' => 120, 'type' => 'bahan']);
        }

        if ($produkPisang) {
            Stock::create(['product_id' => $produkPisang->id, 'quantity' => 50, 'type' => 'produk']);
        }
        if ($produkTempe) {
            Stock::create(['product_id' => $produkTempe->id, 'quantity' => 40, 'type' => 'produk']);
        }
    }
}
