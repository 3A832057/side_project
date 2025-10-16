<?php

namespace App\Http\Controllers\Back;
use App\Http\Controllers\Controller;

use App\Services\Back\ComponentService;
use App\Http\Resources\Back\CategoryResource;
use App\Services\Back\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;
    protected ComponentService $componentService;

    public function __construct(CategoryService $categoryService, ComponentService $componentService)
    {
        $this->categoryService = $categoryService;
        $this->componentService = $componentService;
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

    //找子類別資料表
    public function getChildDatatable(Request $request):array{

        $parents = $request->parent;
        $tableData = $this->categoryService->getDatatableWithparent_id($parents);
        return CategoryResource::collection($tableData)->response()->getData(true) ;

    }

    //找特定階層資料表
    public function getDatatableWithLevel($level):array{

        $tableData = $this->categoryService->getDatatable($level);
        return CategoryResource::collection($tableData)->response()->getData(true);

    }

    // 更新類別資料
    public function update($id, Request $request){

        try {
            $beforeData = $this->categoryService->find($id);

            $userData = $this->categoryService->update($id , $request->all());

            $this->componentService->writeAdminLog('update', 'categories', $beforeData['data'], $userData['data']);

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

    // 更新類別前端顯示順序
    public function setSort_order(Request $request){

        try {
            $beforeData = $this->categoryService->get(null);
            $data = $this->categoryService->setSort_order($request->all());

            $this->componentService->writeAdminLog('update', 'categories', $beforeData['data'], $data['data']);

            return response()->json([
                'success' => $data['success'],
                'message' => '更新成功!',
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
    //取得父類別清單
    public function getParentList($level){

        try {

           $params = [
                'level' => $level,
            ];
            $tableData = $this->categoryService->get($params);
            $newData = [];
            foreach($tableData['data'] as $key => $item){
                $newData['data'][$key]['label'] = $item['name'];
                $newData['data'][$key]['value'] = $item['id'];
            }
            return $newData['data'];

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

            $this->componentService->writeAdminLog('create', 'categories', $request->all(), $data['data']);
            
            return response()->json([
                'success' => $data['success'],
                'message' => $data['message'],
                'data' => $data['data'],
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
            $categoriesData = $this->categoryService->get($params);

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
