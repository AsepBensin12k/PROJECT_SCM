<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            SupplierSeeder::class,
            MaterialSeeder::class,
            ProductSeeder::class,
            StockSeeder::class,
            ProductionSeeder::class,
            DistributionSeeder::class,
            ForecastSeeder::class,
        ]);
    }
}
