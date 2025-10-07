<?php

namespace App\Http\Controllers\Back;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class ComponentController extends Controller
{
    function uploadImg(Request $request){
        // dd($request->file .';'.$request->storePath);

        if ($request->file) {
            $file = $request->file;
            $storeDir = $request->storeDir;
            // 儲存到 public/storage/images 資料夾
            $path = $file->store('images/'.$storeDir, 'public');

            // 回傳儲存路徑或其他資料
            return response()->json([
                'message' => '上傳成功',
                'path' => $path
            ]);
        }
    }
    
    
}
