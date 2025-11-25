<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Keripik Pisang ROJEMBER',
            'description' => 'Keripik pisang manis renyah 100gr',
            'price' => 15000,
            'stock' => 50
        ]);
    }
}
