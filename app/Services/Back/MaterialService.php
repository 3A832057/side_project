<?php

namespace App\Services\Back;

use App\Models\Material;
use Illuminate\Support\Facades\DB;

class MaterialService
{
    
    //找材料資料表
    public function getDatatable($level = 1)
    {
        return Product_material::query()
            ->select(['id', 'name', 'parent_id', 'description', 'sort_order', 'is_enabled','created_at', 'updated_at'])
            ->where('level', $level)
            ->get();
    }

    public function update($id , $data)
    {

        $user = Product_material::find($id);

        if (!$user) {
            return [
                    'success' => false, 
                    'message' => '找不到類別',
                    'data' => null
            ];
        }

        $updateData = [];

        if (isset($data['name'])) {
            $updateData['name'] = $data['name'];
        }

        if (isset($data['description'])) {
            $updateData['description'] = $data['description'];
        }

        if (isset($data['is_enabled'])) {
            $updateData['is_enabled'] = $data['is_enabled'];
        }
        if (isset($data['parent_id'])) {
            $updateData['parent_id'] = $data['parent_id'];
        }
        $user->update($updateData);
        return [
                'success' => true, 
                'message' => '更新成功!',
                'data' => $user
        ];
    }
  
    //新增材料
    public function store($data){
        
        $query = Product_material::create($data);
        return [
                'success' => true,
                'message' => '新增資料成功!',
                'data' => $query
            ];
    }

    //取得陣列資料
    public function get($params)
    {
        $query = Material::query()
            ->select(['id', 'name', 'material_code', 'cost' , 'quantity', 'low_danger', 'is_enabled','created_at', 'updated_at']);

        if (isset($params['is_enabled'])) {
            $query->where('is_enabled', $params['is_enabled']);
        }

        return [
                'success' => true,
                'message' => '取得資料成功!',
                'data' => $query->get()
            ];
    }

}