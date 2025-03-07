<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
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
    }
}
