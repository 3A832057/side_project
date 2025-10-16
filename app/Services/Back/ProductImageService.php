<?php

namespace App\Services\Back;

use App\Models\Product_image;

class ProductImageService
{
    // 更新單一產品圖片資料
    public function update($id , $data)
    {

        $product = Product_image::find($id);

        if (!$product) {
            return [
                    'success' => false, 
                    'message' => '找不到產品',
                    'data' => null
            ];
        }

        $updateData = [];

        if (isset($data['name'])) {
            $updateData['name'] = $data['name'];
        }

        if (isset($data['email'])) {
            $updateData['email'] = $data['email'];
        }

        if (isset($data['role_id'])) {
            $updateData['role_id'] = $data['role_id'];
        }

        if (isset($data['is_enabled'])) {
            $updateData['is_enabled'] = $data['is_enabled'];
            $updateData['disabled_at'] = $data['is_enabled'] ? null : now();
        }
        $product->update($updateData);
        return [
                'success' => true, 
                'message' => '更新成功!',
                'data' => $product
        ];
    }

    // 更新某產品全部圖片資料
    public function updateProductImages($productMain , $data)
    {


        $product = Product_image::destroy( 
            Product_image::where('product_id', $productMain->id)
            ->get()
        );

        
        $rows = [];
        foreach ($data as $index => $img) {
            if (empty($img)) continue;


            $rows[] = [
                'product_id' => $productMain->id,
                'url' => $img,
                'sort_order' => $index,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        if (!empty($rows)) {
            
            $productMain->images()->createMany($rows);
        }
        return [
                'success' => true, 
                'message' => '更新成功!',
                'data' => $productMain
        ];
    }

    // 新增某產品全部圖片資料
    public function addProductImages($productMain , $data)
    {

        $rows = [];
        foreach ($data['images'] as $index => $img) {
            if (empty($img)) continue;


            $rows[] = [
                'product_id' => $productMain->id,
                'url' => $img,
                'sort_order' => $index,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        if (!empty($rows)) {
            $productMain['data']->images()->createMany($rows);
        }
        return [
                'success' => true, 
                'message' => '更新成功!',
                'data' => $productMain['data']
        ];
    }
}