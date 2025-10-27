<?php

namespace App\Http\Resources\Back;
use DB;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductSetResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'product_id'  => $this->product_id,
            'price'       => $this->price,
            'name'        => $this->name,
            'created_at'  => $this->created_at ? $this->created_at->toDateTimeString() : null,
            'updated_at'  => $this->updated_at ? $this->updated_at->toDateTimeString() : null,
            'level'       => $this->level,
            'parent_id'   => $this->parent_id,
        ];
    }
}
