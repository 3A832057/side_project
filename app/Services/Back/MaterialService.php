<?php

namespace App\Services\Back;

use App\Models\Material;
use Illuminate\Support\Facades\DB;

class MaterialService
{
    
    //找材料資料表
    public function getDatatable($level = 1)
    {
        return Material::query()
            ->select('*')
            ->where('is_hidden', 0)
            ->get();
    }

    public function update($id , $data)
    {

        $material = Material::find($id);

        if (!$material) {
            return [
                    'success' => false, 
                    'message' => '找不到材料',
                    'data' => null
            ];
        }

        $updateData = [];

        if (isset($data['name'])) {
            $updateData['name'] = $data['name'];
        }

        if (isset($data['is_enabled'])) {
            $updateData['is_enabled'] = $data['is_enabled'];
        }

        if (isset($data['is_hidden'])) {
            $updateData['is_hidden'] = $data['is_hidden'];
        }

        if (isset($data['cost'])) {
            $updateData['cost'] = $data['cost'];
        }

        if (isset($data['low_danger'])) {
            $updateData['low_danger'] = $data['low_danger'];
        }

        if (isset($data['quantity'])) {
            $updateData['quantity'] = $data['quantity'];
        }

        if (isset($data['material_code'])) {
            $updateData['material_code'] = $data['material_code'];
        }
        $material->update($updateData);


        return [
                'success' => true, 
                'message' => '更新成功!',
                'data' => $material
        ];
    }
  
    //新增材料
    public function store($data){
        
        $query = Material::create($data);
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

    // 用id找單一材料資料
    public function find($id)
    {
        $material = Material::query()->where('id', $id)->first();

        if (!$material) {
            return [
                'success' => false,
                'message' => '材料不存在',
                'data' => null,
            ];
        }

        return [
            'success' => true,
            'message' => '取得成功',
            'data' => $material,
        ];
    }

}