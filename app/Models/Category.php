<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'parent_id',
        'description',
        'is_enabled',
        'sort_order',
        'level',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
