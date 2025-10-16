<?php

namespace App\Services\Back;

use App\Models\Product_material;

class ProductMaterialService
{
    // 更新單一產品材料
    public function addProductMaterial($productMain , $sort_order, $setModel , $item)
    {

        $material = [
            'product_id' => $productMain->id,
            'set_id' => $setModel->id,
            'name' => $item['name'] ?? '',
            'material_id' => $item['data'] ?? null,
            'sort_order' => $sort_order ?? 0,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        $newMaterial = $setModel->materials()->create($material);

        return [
                'success' => true, 
                'message' => '新增成功!',
                'data' => $newMaterial
        ];

    }

    public function destroyByProductId($product_id)
    {
        return Product_material::destroy( 
            Product_material::where('product_id', $product_id)
            ->get()
        );
    }

}