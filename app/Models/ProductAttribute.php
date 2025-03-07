<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'value'
    ];

    /**
     * Relasi ke Product (Many-to-One)
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
