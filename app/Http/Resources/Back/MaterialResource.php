<?php

namespace App\Http\Resources\Back;
use DB;
use Illuminate\Http\Resources\Json\JsonResource;

class MaterialResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'         => $this->name,
            'material_code' => $this->material_code,
            'quantity'      => $this->quantity,
            'cost'         => $this->cost,
            'low_danger'  => $this->low_danger,
            'is_enabled'  => $this->is_enabled,
            'is_hidden'   => $this->is_hidden,
            'hidden_at'  => $this->hidden_at,
            'created_at'  => $this->created_at ? $this->created_at->toDateTimeString() : null,
            'updated_at'  => $this->updated_at ? $this->updated_at->toDateTimeString() : null,
        ];
    }
}
