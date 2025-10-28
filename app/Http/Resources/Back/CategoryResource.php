<?php

namespace App\Http\Resources\Back;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {

       
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'parent'     => $this->parent,
            'parent_id'  => $this->parent_id,
            'created_at'  => $this->created_at ? $this->created_at->toDateTimeString() : null,
            'updated_at'  => $this->updated_at ? $this->updated_at->toDateTimeString() : null,
            'is_enabled' => $this->is_enabled,
            'description'=> $this->description,
            'sort_order' => $this->sort_order,
        ];
    }
}
