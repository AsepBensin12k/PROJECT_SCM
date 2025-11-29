<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\{Production, ProductionMaterial, User, Material, Product};
use Carbon\Carbon;

class ProductionSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $materials = Material::all();
        $products = Product::all();

        if (!$user || $materials->isEmpty() || $products->isEmpty()) {
            $this->command->error('❌ Data User, Material, atau Product tidak ditemukan!');
            return;
        }

        // 🔹 Nonaktifkan foreign key check
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Production::query()->delete();
        ProductionMaterial::query()->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('🚀 Membuat data produksi 5 bulan terakhir...');

        $productionCode = 1;

        // 🔹 Buat data produksi untuk 5 bulan terakhir
        // Loop dari bulan terlama ke terbaru
        for ($monthAgo = 4; $monthAgo >= 0; $monthAgo--) {
            $startDate = Carbon::now()->subMonths($monthAgo)->startOfMonth();
            $endDate = Carbon::now()->subMonths($monthAgo)->endOfMonth();
            
            // 🔹 Buat 3-5 produksi per bulan agar data lebih realistis
            $productionsPerMonth = rand(3, 5);
            
            $this->command->info("📅 Bulan: {$startDate->format('F Y')} - Membuat {$productionsPerMonth} produksi");

            for ($j = 0; $j < $productionsPerMonth; $j++) {
                // Random tanggal dalam bulan tersebut
                $randomDay = rand(1, $endDate->day);
                $productionDate = $startDate->copy()->day($randomDay);
                
                $product = $products->random();

                $production = Production::create([
                    'code' => 'PRD' . str_pad($productionCode, 3, '0', STR_PAD_LEFT),
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'quantity_produced' => rand(40, 120),
                    'production_date' => $productionDate,
                    'operator' => 'Bagian Produksi',
                    'status' => 'selesai',
                ]);

                // 🔹 Gunakan 3-5 bahan baku random per produksi
                $usedMaterials = $materials->random(rand(3, 5));
                
                foreach ($usedMaterials as $mat) {
                    ProductionMaterial::create([
                        'production_id' => $production->id,
                        'material_id' => $mat->id,
                        'quantity_used' => rand(5, 25), // Quantity yang lebih bervariasi
                    ]);
                }

                $this->command->info("   ✅ {$production->code} - {$productionDate->format('d M Y')} - {$product->name}");
                $productionCode++;
            }
        }

        $totalProductions = Production::count();
        $totalMaterialUsage = ProductionMaterial::count();
        
        $this->command->info("✨ Selesai! Total: {$totalProductions} produksi, {$totalMaterialUsage} penggunaan bahan baku");
    }
}