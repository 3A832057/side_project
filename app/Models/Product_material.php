<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_material extends Model
{
    
    protected $fillable = [
        'product_id',
        'material_id',
        'sort_order',
        'set_id',
        'is_hidden',
        'hidden_at',
    ];
    // public function set()
    // {
    //     return $this->belongsTo(Product_set::class, 'set_id', 'id');
    // }
    public function material()
    {
        return $this->hasMany(Material::class, 'id', 'material_id');
    }
}
