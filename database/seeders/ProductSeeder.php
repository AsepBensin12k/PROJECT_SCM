<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::query()->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Product::insert([
            ['name' => 'Keripik Pisang ROJEMBER', 'description' => 'Keripik pisang renyah rasa original 100gr', 'price' => 15000, 'stock' => 50],
            ['name' => 'Keripik Pisang ROJEMBER 500gr', 'description' => 'Varian besar 500gr', 'price' => 70000, 'stock' => 25],
            ['name' => 'Keripik Pisang ROJEMBER 1kg', 'description' => 'Varian keluarga 1kg', 'price' => 130000, 'stock' => 15],
            ['name' => 'Keripik Pisang Coklat 500gr', 'description' => 'Keripik pisang dilapisi coklat bubuk khas Jember', 'price' => 75000, 'stock' => 20],
            ['name' => 'Keripik Tempe ROJEMBER', 'description' => 'Keripik tempe gurih renyah khas Jember', 'price' => 18000, 'stock' => 40],
        ]);
    }
}
