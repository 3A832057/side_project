<?php

namespace App\Services\Back;

use App\Models\User;

class AdminService
{
    //找管理員資料表
    public function getDatatable($serchValue)
    {
        return User::query()
            ->select(['id', 'name', 'email'])
            ->where('role_id', '!=', '0') // Exclude admin users if needed
            ->get()
            ->toArray();
    }
    
}