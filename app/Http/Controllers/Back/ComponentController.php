<?php

namespace App\Http\Controllers\Back;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Back\ComponentService;

class ComponentController extends Controller
{
    protected ComponentService $componentService;
    public function __construct(ComponentService $componentService){
        $this->componentService = $componentService;
    }
    //上傳圖片 傳入參數為 上傳本檔 multipart/form-data格式 以及要儲存的dir 命名分別為file跟storeDir
    function uploadImg(Request $request){
        try {
            $file = $request->file;
            $storeDir = $request->storeDir;
            
            // 儲存到 public/storage/images 資料夾
            $imageData = $this->componentService->uploadImg($file,$storeDir);

            return response()->json([
                'success' => $imageData['success'],
                'message' => $imageData['message'],
                'data' => $imageData['data'],
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
