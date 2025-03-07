<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Elektronik',
                'description' => 'Kategori untuk barang-barang elektronik seperti laptop, handphone, dan aksesori lainnya.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Peralatan Rumah Tangga',
                'description' => 'Kategori untuk peralatan rumah tangga seperti blender, rice cooker, dan lainnya.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pakaian',
                'description' => 'Kategori untuk berbagai jenis pakaian pria dan wanita.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Makanan & Minuman',
                'description' => 'Kategori untuk produk makanan dan minuman.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Olahraga',
                'description' => 'Kategori untuk perlengkapan olahraga seperti sepatu, bola, dan alat gym.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('categories')->insert($categories);

        Setting::create([
            'site_name' => 'Stockify',
            'logo' => null, // Awalnya kosong
        ]);

        $suppliers = [
            [
                'name' => 'PT. Sumber Elektronik',
                'address' => 'Jl. Sudirman No. 45, Jakarta',
                'phone' => '081234567890',
                'email' => 'contact@sumberelektronik.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'CV. Maju Jaya',
                'address' => 'Jl. Merdeka No. 12, Bandung',
                'phone' => '081298765432',
                'email' => 'info@majujaya.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'UD. Sentosa Abadi',
                'address' => 'Jl. Diponegoro No. 88, Surabaya',
                'phone' => '081322334455',
                'email' => 'sales@sentosaabadi.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PT. Mitra Sejahtera',
                'address' => 'Jl. Gatot Subroto No. 99, Medan',
                'phone' => '081355667788',
                'email' => 'support@mitrasejahtera.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'CV. Jaya Abadi',
                'address' => 'Jl. Ahmad Yani No. 21, Yogyakarta',
                'phone' => '081366778899',
                'email' => 'cs@jayaabadi.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('suppliers')->insert($suppliers);

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
