<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stock_opnames', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null'); // Relasi ke produk
            $table->integer('initial_stock');  // Stok sebelum opname
            $table->integer('final_stock');    // Stok setelah opname
            $table->integer('difference');     // Selisih stok (bisa negatif)
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->date('date');
            $table->timestamps();              // Waktu opname dilakukan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_opnames');
    }
};
