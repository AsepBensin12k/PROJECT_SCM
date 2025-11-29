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

        if (!$owner || !$produk) {
            return;
        }

        $distributions = [
            [
                'destination' => 'Toko Oleh-Oleh Jember',
                'quantity' => 10,
                'status' => 'dikirim',
                'notes' => 'Pengiriman awal ke outlet utama',
            ],
            [
                'destination' => 'Reseller Surabaya',
                'quantity' => 15,
                'status' => 'selesai',
                'notes' => 'Sudah diterima oleh reseller',
            ],
            [
                'destination' => 'Toko Probolinggo',
                'quantity' => 8,
                'status' => 'diproses',
                'notes' => 'Dalam proses pengepakan',
            ],
        ];

        foreach ($distributions as $index => $data) {
            // 🔹 Generate kode otomatis DST0001 dst
            $latest = Distribution::max('code');
            $nextCode = $latest
                ? 'DST' . str_pad((int)substr($latest, 3) + 1, 4, '0', STR_PAD_LEFT)
                : 'DST0001';

            Distribution::create([
                'code' => $nextCode,
                'user_id' => $owner->id,
                'product_id' => $produk->id,
                'destination' => $data['destination'],
                'quantity' => $data['quantity'],
                'status' => $data['status'],
                'notes' => $data['notes'],
            ]);
        }

    }
}
