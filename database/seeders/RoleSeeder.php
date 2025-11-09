<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::insert([
            ['name' => 'Owner', 'description' => 'Pemilik usaha ROJEMBER', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Koordinator', 'description' => 'Pengelola gudang & produksi', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Admin', 'description' => 'Pendukung operasional SCM', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
