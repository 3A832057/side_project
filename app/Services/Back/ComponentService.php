<?php

namespace App\Services\Back;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ComponentService
{
    //上傳圖片
    public function uploadImg($img , $storeDir)
    {
        $path = $img->store('images/'.$storeDir, 'public');
        return [
                'success' => true, 
                'message' => '上傳成功!',
                'data' =>asset('storage/' . $path)
        ];
    }
    //寫管理員log
    public function writeAdminLog($action , $beforeDetails, $afterDetails)
    {
        $log = [
            'action' => $action,
            'user_id' => Auth::id(),
            'user_account' => Auth::user()->account ?? '未知使用者',
            'before' => $beforeDetails,
            'after' => $afterDetails,
            'created_at' => now(),
        ];
        
        return $log;
    }

}