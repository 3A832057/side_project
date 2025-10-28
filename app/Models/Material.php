<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'material_code',
        'name',
        'cost',
        'price',
        'quantity',
        'is_enable',
        'is_hidden',
        'hidden_at',
        'low_danger'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_materials', 'material_id', 'product_id');
    }
    public function sets()
    {
        return $this->belongsToMany(Product_set::class, 'product_materials', 'material_id', 'set_id');
    }
}
