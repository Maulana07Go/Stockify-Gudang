<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'profile_photo' => null,
                'password' => Hash::make('password123'),
                'role' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Staff Gudang',
                'email' => 'staff@example.com',
                'profile_photo' => null,
                'password' => Hash::make('password123'),
                'role' => 'Staff Gudang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Manajer Gudang',
                'email' => 'manajer@example.com',
                'profile_photo' => null,
                'password' => Hash::make('password123'),
                'role' => 'Manajer Gudang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('users')->insert($users);
    }
}
