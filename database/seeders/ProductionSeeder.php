<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Production;
use App\Models\User;
use App\Models\Material;
use App\Models\Product;

class ProductionSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::whereHas('role', fn($q) => $q->where('name', 'Koordinator'))->first();
        $pisang = Material::where('name', 'Pisang Raja')->first();
        $produk = Product::where('name', 'Keripik Pisang ROJEMBER')->first();

        Production::create([
            'user_id' => $user->id,
            'material_id' => $pisang->id,
            'product_id' => $produk->id,
            'quantity_used' => 10,
            'quantity_produced' => 20,
            'production_date' => now()
        ]);
    }
}
