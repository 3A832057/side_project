<?php

namespace App\Services\Back;

use App\Models\Product_set;

class ProductSetService
{
    // 更新單一產品組件資料
    public function addProductSet($productMain , $set , $parentArr)
    {

        $setFirst = $set['first'] ?? null;
        $setSecond = $set['second'] ?? null;

        if ($setSecond === null) {
            $parent = [
                'product_id' => $productMain->id,
                'name' => $set['data'] ?? '',
                'price' => $set['price'] ?? 0,
                'parent_id' => null,
                'level' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $setModel = $productMain->sets()->create($parent);
            $NewParent['id'] = $setModel->id;
            $NewParent['first'] = $setFirst;
            $NewParent['set'] = $setModel;
            return $NewParent;
        }

        if ($setSecond !== null) {
            foreach ($parentArr as $p) {
                if ($p['first'] === $setFirst && $p['id'] != null) {

                    $parent_id = $p['id'];

                    $parent = [
                        'product_id' => $productMain->id,
                        'name' => $set['data'] ?? '',
                        'price' => $set['price'] ?? 0,
                        'parent_id' => $parent_id,
                        'level' => 2,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    $setModel = $productMain->sets()->create($parent);

                    $NewParent['first'] = null;
                    $NewParent['id'] = null;
                    $NewParent['set'] = $setModel;
                    return $NewParent;
                }
            }

        }
    }


    // 刪除某產品全部組件資料
    public function destroyByProductId($product_id)
    {

        $deleted = Product_set::where('product_id', $product_id)->delete();

        return [
            'success' => true,
            'message' => '刪除成功!',
            'data' => $deleted
        ];
    }


}