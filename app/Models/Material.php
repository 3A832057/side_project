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
        'is_enabled',
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
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function material_quantity_log()
    {
        return $this->hasMany(Material_quantity_log::class, 'material_id', 'id');
    }
}
