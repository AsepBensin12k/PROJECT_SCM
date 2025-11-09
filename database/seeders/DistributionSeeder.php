<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Distribution;
use App\Models\User;
use App\Models\Product;

class DistributionSeeder extends Seeder
{
    public function run(): void
    {
        $owner = User::whereHas('role', fn($q) => $q->where('name', 'Owner'))->first();
        $produk = Product::where('name', 'Keripik Pisang ROJEMBER')->first();

        Distribution::create([
            'user_id' => $owner->id,
            'product_id' => $produk->id,
            'destination' => 'Toko Oleh-Oleh Jember',
            'quantity' => 10,
            'status' => 'dikirim'
        ]);

        Distribution::create([
            'user_id' => $owner->id,
            'product_id' => $produk->id,
            'destination' => 'Reseller Surabaya',
            'quantity' => 15,
            'status' => 'diproses'
        ]);
    }
}
