<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'supplier_id',
        'name',
        'sku',
        'description',
        'purchase_price',
        'selling_price',
        'image',
        'minimum_stock',
        'stock', 
        'reorder_point', 
        'average_usage', 
        'average_lead_time'
    ];

    /**
     * Relasi ke Category (Many-to-One)
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi ke Supplier (Many-to-One)
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Relasi ke ProductAttributes (One-to-Many)
     */
    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    /**
     * Relasi ke StockTransaction (One-to-Many)
     */
    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class);
    }
}
