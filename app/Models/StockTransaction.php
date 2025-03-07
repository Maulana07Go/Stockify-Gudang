<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'type',
        'quantity',
        'date',
        'status',
        'notes'
    ];

    /**
     * Relasi ke Product (Many-to-One)
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relasi ke User (Many-to-One)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
