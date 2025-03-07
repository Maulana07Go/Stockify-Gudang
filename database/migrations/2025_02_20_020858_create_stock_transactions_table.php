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
        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('type', ['Masuk', 'Keluar']);
            $table->integer('quantity');
            $table->date('date');
            $table->enum('status', ['Pending', 'Diterima', 'Ditolak', 'Dikeluarkan']);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_transactions');
    }
};
