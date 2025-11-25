<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $ownerRole = Role::where('name', 'Owner')->first();
        $koordinatorRole = Role::where('name', 'Koordinator')->first();

        User::create([
            'role_id' => $ownerRole->id,
            'name' => 'Owner ROJEMBER',
            'email' => 'owner@rojember.com',
            'password' => bcrypt('password')
        ]);

        User::create([
            'role_id' => $koordinatorRole->id,
            'name' => 'Koordinator Gudang',
            'email' => 'koordinator@rojember.com',
            'password' => bcrypt('password')
        ]);
    }
}
