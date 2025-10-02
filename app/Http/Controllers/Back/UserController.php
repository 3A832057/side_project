<?php

namespace App\Http\Controllers\Back;
use App\Http\Controllers\Controller;
use App\Services\Back\UserService;
use Illuminate\Http\Request;
use App\Http\Resources\Back\UserResource;

class UserController extends Controller
{
    
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    //找會員資料表
    public function getDatatable(Request $request):array{

        $data = $request->all();

        // dd($data);
        $tableData = $this->userService->getDatatable($data);
        return UserResource::collection($tableData)->response()->getData(true);

    }

    // 找單一會員資料
    public function find($id){

        try {
            $userData = $this->userService->find($id);

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

    // 更新使用者資料
    public function update($id, Request $request){

        try {

            $userData = $this->userService->update($id , $request->all());

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
    
}
