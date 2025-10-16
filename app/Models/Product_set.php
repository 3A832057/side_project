<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_set extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'price',
        'level',
        'parent_id',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function materials()
    {
        return $this->hasMany(Product_material::class, 'set_id', 'id');
    }
}
