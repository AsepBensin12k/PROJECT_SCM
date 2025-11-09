<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stock;
use App\Models\Material;
use App\Models\Product;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        $pisang = Material::where('name', 'Pisang Raja')->first();
        $produk = Product::where('name', 'Keripik Pisang ROJEMBER')->first();

        Stock::create(['material_id' => $pisang->id, 'quantity' => 100, 'type' => 'bahan']);
        Stock::create(['product_id' => $produk->id, 'quantity' => 50, 'type' => 'produk']);
    }
}
