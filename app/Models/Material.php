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

    public function productMaterials()
    {
        return $this->hasMany(Product_material::class, 'material_id', 'id');
    }
}
