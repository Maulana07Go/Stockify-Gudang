<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StockTransaction;
use Carbon\Carbon;

class StockTransactionSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 50; $i++) {
            StockTransaction::create([
                'product_id' => 3,
                'user_id' => 2,
                'type' => 'Keluar',
                'quantity' => rand(10, 40), // Quantity acak antara 10 - 100
                'date' => Carbon::now()->subDays(rand(0, 730)), // Tanggal acak 2 tahun ke belakang
                'status' => 'Dikeluarkan',
                'notes' => 'barang masuk dari supplier',
            ]);
        }
    }
}
