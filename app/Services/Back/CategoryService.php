<?php

namespace App\Services\Back;

use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    
    //找主類別資料表
    public function getDatatable($level = 1)
    {
        return Category::query()
            ->select(['id', 'name', 'parent_id', 'description', 'sort_order', 'is_enabled','created_at', 'updated_at'])
            ->where('level', $level)
            ->get();
    }

    //找子類別資料表
    public function getDatatableWithparent_id($serchValue = [])
    {


        if (empty($serchValue)) {
            return [];
        }
        return Category::query()
            ->select(['id', 'name', 'parent_id', 'description', 'sort_order', 'is_enabled','created_at', 'updated_at'])
            ->whereIn('parent_id', $serchValue)
            ->with('parent')->with('parent.parent')
            ->get() ?? null;
    }

    // 找單一會員資料
    // public function find($id)
    // {

    //     $user = User::find($id);

    //     if (!$user) 
    //         return [
    //             'success' => false,
    //             'message' => '使用者不存在',
    //             'data' => null,
    //         ];

    //     return [
    //             'success' => false,
    //             'message' => '使用者不存在',
    //             'data' => $user,
    //         ];
    // }

    // 更新類別資料
    public function update($id , $data)
    {

        $user = Category::find($id);

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
    public function setSort_order($data)
    {
        DB::beginTransaction();
        try {
            $sortNumber = 1;
            foreach ($data['tableData']  as $item) {
                $category = Category::find($item['id']);
                if ($category) {
                    $category->sort_order = $sortNumber;
                    $category->save();
                    $sortNumber++;
                }
            }

            $sortNumber = 1;
            foreach ($data['tableChildData']  as $item) {
                $category = Category::find($item['id']);
                if ($category) {
                    $category->sort_order = $sortNumber;
                    $category->save();
                    $sortNumber++;
                }
            }
            
            $sortNumber = 1;
            foreach ($data['tableGrandChildData']  as $item) {
                $category = Category::find($item['id']);
                if ($category) {
                    $category->sort_order = $sortNumber;
                    $category->save();
                    $sortNumber++;
                }
            }
            DB::commit();
            return [
                'success' => true,
                'message' => '排序更新成功!',
                'data' => null
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => '排序更新失敗: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }
    
    //取得陣列資料
    public function get($params)
    {
        $query = Category::query()
            ->select(['id', 'name', 'parent_id', 'description','level', 'sort_order', 'is_enabled','created_at', 'updated_at']);

        if (isset($params['level'])) {
            $query->where('level', $params['level']);
        }

        return [
                'success' => true,
                'message' => '取得資料成功!',
                'data' => $query->get()
            ];
    }

    //新增類別
    public function store($data){
        
        $query = Category::create($data);
        return [
                'success' => true,
                'message' => '新增資料成功!',
                'data' => $query
            ];
    }
}