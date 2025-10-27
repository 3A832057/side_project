<?php

namespace App\Services\Back;

use App\Models\Product;

class ProductService
{
    //找產品資料表
    public function getDatatable($serchValue)
    {
        if (!empty($serchValue)) {
            return Product::query()
                ->select('*')
                ->with(['categories', 'images', 'sets','materials','groups'])
                ->where('is_hidden', false)
                ->where(function ($query) use ($serchValue) {
                    foreach ($serchValue as $condition) {
                        $field = $condition['field'];
                        $type = $condition['type'];
                        $value = $condition['value'];
                        if (isset($condition['join_table'])) {
                            $joinTable = $condition['join_table'];
                            $query->whereHas($joinTable, function ($q) use ($field, $type, $value) {
                                if ($type !== 'like') {
                                    $q->where($field, $type, $value);
                                }
                                elseif ($type === 'like') {
                                    $q->where($field, 'like', '%' . $value . '%');
                                }
                            });
                        } else {
                            if ($type !== 'like') {
                                $query->where($field, $type, $value);
                            } elseif ($type === 'like') {
                                $query->where($field, 'like', '%' . $value . '%');
                            }
                            
                        }
                    }
                })
                ->get();
        }
        return Product::query()
            ->select('*')
                ->with(['categories', 'images', 'sets','materials','groups'])
            ->where('is_hidden', false)
            ->get();
    }

    // 找單一產品資料
    public function find($id)
    {

        // 使用 eager-loading 在查詢階段載入需要的關聯
        $product = Product::with([
            'categories',
            'images',
            'sets.materials',
            'groups',
        ])->find($id);

        if (!$product) {
            return [
                'success' => false,
                'message' => '產品不存在',
                'data' => null,
            ];
        }

        return [
            'success' => true,
            'message' => '取得成功',
            'data' => $product,
        ];
    }

    // 更新產品主檔資料
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

        if (isset($data['product_code'])) {
            $updateData['product_code'] = $data['product_code'];
        }

        if (isset($data['description'])) {
            $updateData['description'] = $data['description'];
        }

        if (isset($data['is_enabled'])) {
            $updateData['is_enabled'] = $data['is_enabled'];
        }

        if (isset($data['sort_order'])) {
            $updateData['sort_order'] = $data['sort_order'];
        }

        if (isset($data['is_hidden'])) {
            $updateData['is_hidden'] = $data['is_hidden'];
        }

        if (isset($data['hidden_at'])) {
            $updateData['hidden_at'] = $data['hidden_at'];
        }

        if (isset($data['price'])) {
            $updateData['price'] = $data['price'];
        }
        
      
        $product->update($updateData);

        $product = Product::with([
            'categories',
            'images',
            'sets.materials',
            'groups',
        ])->find($id);
        
        return [
                'success' => true, 
                'message' => '更新成功!',
                'data' => $product
        ];
    }

    //新增產品主表
    public function store($data){

        $product = $data['product'];
        $query = Product::create($product);
        return [
                'success' => true,
                'message' => '新增資料成功!',
                'data' => $query
            ];
    }

    
}