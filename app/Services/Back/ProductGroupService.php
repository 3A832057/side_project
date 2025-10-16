<?php

namespace App\Services\Back;

use App\Models\Product_group;

class ProductGroupService
{
    // 更新單一產品群組分類
    public function addProductGroup($productMain , $set)
    {

        $group = $set['group_name'] ?? '';
        $groupNumber = $set['group_number'] ?? 0;

        for ($i=0; $i < $groupNumber; $i++) {
             $group = [
                'product_id' => $productMain->id,
                'name' => $group[$i] ?? '',
                'level' => $i + 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $newGroup = $productMain->groups()->create($group);
        }
       

        return [
                'success' => true, 
                'message' => '新增成功!',
                'data' => $newGroup
        ];

    }

    public function destroyByProductId($product_id)
    {
        return Product_group::destroy( 
            Product_group::where('product_id', $product_id)
            ->get()
        );
    }

}