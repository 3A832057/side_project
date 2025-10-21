<?php

namespace App\Http\Controllers\Back;
use App\Http\Controllers\Controller;

use App\Http\Resources\Back\MaterialResource;
use App\Services\Back\MaterialService;
use Illuminate\Http\Request;

use App\Services\Back\ComponentService;
class MaterialControlle extends Controller
{
    protected MaterialService $materialService;
    protected ComponentService $componentService;

    public function __construct(MaterialService $materialService, ComponentService $componentService)
    {
        $this->materialService = $materialService;
        $this->componentService = $componentService;
    }

    public function get(Request $request){

        try {

            $allData = $this->materialService->get(null);

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
    //找材料資料表
    public function getDatatable():array{

        $tableData = $this->materialService->getDatatable();
        return MaterialResource::collection($tableData)->response()->getData(true);

    }

    // 找單一材料資料
    public function find($id){
        $material = $this->materialService->find($id);
        return response()->json([
            'success' => $material['success'],
            'message' => $material['message'],
            'data' => $material['data'],
        ]);
    }

    // 更新材料資料
    public function update($id, Request $request){

        try {

            $beforeData = $this->materialService->find($id);
            $userData = $this->materialService->update($id , $request->all());
            $afterData = $this->materialService->find($id);

            $this->componentService->writeAdminLog('update', 'materials', $beforeData, $afterData['data']);
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

            $data = $this->materialService->store($request->all());

            $this->componentService->writeAdminLog('create', 'materials', null, $data['data']);
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

    
    
}
