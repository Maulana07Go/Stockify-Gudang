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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->onDelete('set null');
            $table->string('name');
            $table->string('sku')->unique()->comment('Stock Keeping Unit');
            $table->text('description')->nullable();
            $table->integer('purchase_price');
            $table->integer('selling_price');
            $table->string('image')->nullable()->comment('Path ke file gambar');
            $table->integer('minimum_stock')->default(0);
            $table->integer('stock')->default(0);
            $table->integer('reorder_point')->default(0);
            $table->integer('average_usage')->default(0);
            $table->integer('average_lead_time')->default(0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
