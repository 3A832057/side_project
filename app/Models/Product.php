<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'product_code',
        'description',
        'is_enabled',
        'sort_order',
        'is_hidden',
        'hidden_at',
        'price',
    ];
    /**
     * 多對多：產品屬於多個類別
     */
    public function categories()
    {
        // pivot table 名稱是 product_categories，
        // 外鍵預設 product_id, category_id
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id');
    }

    public function images()
    {
        return $this->hasMany(Product_image::class, 'product_id', 'id');
    }
    
    public function sets()
    {
        return $this->hasMany(Product_set::class, 'product_id', 'id');
    }

    public function groups()
    {
        return $this->hasMany(Product_group::class, 'product_id', 'id');
    }
}
