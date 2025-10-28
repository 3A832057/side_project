<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material_quantity_log extends Model
{
    protected $fillable = [
        'id',
        'material_id',
        'before',
        'quantity',
        'after',
        'description',
        'admin_account',
        'admin_name',
        'created_at',
        'updated_at'
    ];

    public function material()
    {
        return $this->belongsTo(Material::class, 'matetial_id', 'id');
    }


}
