<?php

namespace App\Services\Back;

use App\Models\User;

class UserService
{
    //找會員資料表
    public function getDatatable($serchValue)
    {
        return User::query()
            ->select(['id', 'name', 'email','is_enabled','disabled_at', 'role_id','created_at', 'updated_at'])
            ->get();
    }

    // 找單一會員資料
    public function find($id)
    {

        $user = User::find($id);

        if (!$user) 
            return [
                'success' => false,
                'message' => '使用者不存在',
                'data' => null,
            ];

        return [
                'success' => false,
                'message' => '使用者不存在',
                'data' => $user,
            ];
    }

    // 更新使用者資料
    public function update($id , $data)
    {

        $user = User::find($id);

        if (!$user) {
            return [
                    'success' => false, 
                    'message' => '找不到使用者',
                    'data' => null
            ];
        }

        $updateData = [];

        if (isset($data['name'])) {
            $updateData['name'] = $data['name'];
        }

        if (isset($data['email'])) {
            $updateData['email'] = $data['email'];
        }

        if (isset($data['role_id'])) {
            $updateData['role_id'] = $data['role_id'];
        }

        if (isset($data['is_enabled'])) {
            $updateData['is_enabled'] = $data['is_enabled'];
            $updateData['disabled_at'] = $data['is_enabled'] ? null : now();
        }
        $user->update($updateData);
        return [
                'success' => true, 
                'message' => '更新成功!',
                'data' => $user
        ];
    }
    
}