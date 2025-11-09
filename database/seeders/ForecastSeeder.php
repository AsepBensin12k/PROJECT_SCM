<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Forecast;
use App\Models\Material;

class ForecastSeeder extends Seeder
{
    public function run(): void
    {
        $pisang = Material::where('name', 'Pisang Raja')->first();
        $minyak = Material::where('name', 'Minyak Goreng')->first();

        Forecast::insert([
            [
                'material_id' => $pisang->id,
                'period' => '2025-11',
                'forecast_result' => 120.50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => $minyak->id,
                'period' => '2025-11',
                'forecast_result' => 60.25,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
