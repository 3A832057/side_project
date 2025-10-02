<?php

namespace App\Services\Back;

use App\Models\Product;

class ProductService
{
    //找產品資料表
    public function getDatatable($serchValue)
    {
        return Product::query()
            ->select('*')
            ->where('is_hidden', false)
            ->get();
    }

    // 找單一產品資料
    public function find($id)
    {

        $product = Product::find($id);

        if (!$product) 
            return [
                'success' => false,
                'message' => '產品不存在',
                'data' => null,
            ];

        return [
                'success' => false,
                'message' => '產品不存在',
                'data' => $product,
            ];
    }

    // 更新產品資料
    public function update($id , $data)
    {

        $product = Product::find($id);

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
    
}