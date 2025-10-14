<?php

namespace App\Http\Controllers\Back;
use App\Http\Controllers\Controller;

use App\Http\Resources\Back\CategoryResource;
use App\Services\Back\MaterialService;
use Illuminate\Http\Request;

class MaterialControlle extends Controller
{
    protected MaterialService $materialService;

    public function __construct(MaterialService $materialService)
    {
        $this->materialService = $materialService;
    }

    public function get(Request $request){

        try {

            $allData = $this->categoryService->get(null);

            return response()->json([
                'success' => $allData['success'],
                'message' => $allData['message'],
                'data' => $allData['data'],
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => '伺服器錯誤：' . $e->getMessage(),
                'data' => null,
            ], 500);
        }

        
    }
    //找主類別資料表
    public function getDatatable():array{

        $tableData = $this->categoryService->getDatatable(1);
        return CategoryResource::collection($tableData)->response()->getData(true);

    }

    // 更新類別資料
    public function update($id, Request $request){

        try {

            $userData = $this->categoryService->update($id , $request->all());

            return response()->json([
                'success' => $userData['success'],
                'message' => $userData['message'],
                'data' => $userData['data'],
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => '伺服器錯誤：' . $e->getMessage(),
                'data' => null,
            ], 500);
        }

    }

    public function store(Request $request){
        try {

            $data = $this->categoryService->store($request->all());
            return response()->json([
                'success' => $data['success'],
                'message' => $data['message'],
                'data' => null,
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => '伺服器錯誤：' . $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    //取得所有類別欄位，且使用enabled做篩選
    public function getAllWithEnabled(Request $request){
        try {

            $params = $request->all();
            $categoriesData = $this->materialService->get($params);

            return response()->json([
                'success' => $categoriesData['success'],
                'message' => $categoriesData['message'],
                'data' => $categoriesData['data'],
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => '伺服器錯誤：' . $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }
    
}
