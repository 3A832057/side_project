<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'material_code',
        'name',
        'description',
        'price',
        'stock',
        'is_active',
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
