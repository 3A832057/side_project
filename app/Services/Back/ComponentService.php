<?php

namespace App\Services\Back;

use App\Models\User;

class ComponentService
{
    //找管理員資料表
    public function uploadImg($img , $storeDir)
    {
        $path = $img->store('images/'.$storeDir, 'public');
        return [
                'success' => true, 
                'message' => '上傳成功!',
                'data' =>asset('storage/' . $path)
        ];
    }
    
}