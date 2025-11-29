<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // pastikan role ada, jika belum otomatis dibuat
        $ownerRole = Role::firstOrCreate(['name' => 'owner']);
        $koordinatorRole = Role::firstOrCreate(['name' => 'koordinator']);

        // buat akun Owner
        User::updateOrCreate(
            ['email' => 'owner@rojember.com'],
            [
                'role_id' => $ownerRole->id,
                'name' => 'Owner ROJEMBER',
                'phone' => '081234567890',
                'address' => 'Jl. Merdeka No.1, Jember',
                'password' => Hash::make('password'),
            ]
        );

        // buat akun Koordinator
        User::updateOrCreate(
            ['email' => 'koordinator@rojember.com'],
            [
                'role_id' => $koordinatorRole->id,
                'name' => 'Koordinator',
                'phone' => '089876543210',
                'address' => 'Jl. Merdeka No.2, Jember',
                'password' => Hash::make('password'),
            ]
        );
    }
}
