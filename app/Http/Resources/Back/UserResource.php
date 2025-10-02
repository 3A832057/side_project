<?php

namespace App\Http\Resources\Back;
use DB;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        $all_roles =  DB::table('roles')->get();


        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'email'      => $this->email,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'role_id'    => $this->role_id,
            'role'       => $all_roles,
            'is_enabled' => $this->is_enabled,
            'disabled_at'=> $this->disabled_at ?  $this->disabled_at->toDateTimeString() :null, 
        ];
    }
}
