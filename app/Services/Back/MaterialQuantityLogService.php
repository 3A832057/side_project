<?php

namespace App\Services\Back;

use App\Models\Material_quantity_log;
use Illuminate\Support\Facades\Auth;

class MaterialQuantityLogService
{
    // 更新產品主檔資料
    // public function update($id , $data)
    // {

    //     $product = Product::find($id);

    //     if (!$product) {
    //         return [
    //                 'success' => false, 
    //                 'message' => '找不到產品',
    //                 'data' => null
    //         ];
    //     }

    //     $updateData = [];

    //     if (isset($data['name'])) {
    //         $updateData['name'] = $data['name'];
    //     }

    //     if (isset($data['product_code'])) {
    //         $updateData['product_code'] = $data['product_code'];
    //     }

    //     if (isset($data['description'])) {
    //         $updateData['description'] = $data['description'];
    //     }

    //     if (isset($data['is_enabled'])) {
    //         $updateData['is_enabled'] = $data['is_enabled'];
    //     }

    //     if (isset($data['sort_order'])) {
    //         $updateData['sort_order'] = $data['sort_order'];
    //     }

    //     if (isset($data['is_hidden'])) {
    //         $updateData['is_hidden'] = $data['is_hidden'];
    //     }

    //     if (isset($data['hidden_at'])) {
    //         $updateData['hidden_at'] = $data['hidden_at'];
    //     }

    //     if (isset($data['price'])) {
    //         $updateData['price'] = $data['price'];
    //     }
        
      
    //     $product->update($updateData);

    //     $product = Product::with([
    //         'categories',
    //         'images',
    //         'sets.materials',
    //         'groups',
    //     ])->find($id);
        
    //     return [
    //             'success' => true, 
    //             'message' => '更新成功!',
    //             'data' => $product
    //     ];
    // }

    //新增產品主表
    public function store($data){


        $material_log = $data;

        $material_log['admin_account'] = Auth::user()->email ?? '未知使用者';
        $material_log['admin_name'] = Auth::user()->name ?? '未知使用者';
        $query = Material_quantity_log::create($material_log);
        return [
                'success' => true,
                'message' => '新增資料成功!',
                'data' => $query
            ];
    }
    public function find($id){

        $material_log = Material_quantity_log::find($id);

        return [
                'success' => true,
                'message' => '新增資料成功!',
                'data' => $material_log
            ];
    }

    
}