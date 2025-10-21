<?php

namespace App\Services\Back;

use App\Models\Admin_log;
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
    public function writeAdminLog($action , $mainDataTableName, $beforeDetails, $afterDetails)
    {

        $log = [
            'action' => $action,
            'mainDataTableName' => $mainDataTableName,
            'user_id' => Auth::id(),
            'user_account' => Auth::user()->email ?? '未知使用者',
            'before' => json_encode($beforeDetails, JSON_UNESCAPED_UNICODE),
            'after' => json_encode($afterDetails, JSON_UNESCAPED_UNICODE),
            'created_at' => now(),
        ];
        
        Admin_log::create($log);
    }

}