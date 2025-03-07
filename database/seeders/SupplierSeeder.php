<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
    }
}
