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
        ];
    }
}
