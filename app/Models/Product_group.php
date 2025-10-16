<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_group extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'level',
        'created_at',
        'updated_at',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
