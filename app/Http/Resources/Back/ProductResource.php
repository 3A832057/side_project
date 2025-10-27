<?php

namespace App\Http\Resources\Back;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'product_code'      => $this->product_code,
            'created_at'        => $this->created_at ? $this->created_at->toDateTimeString() : null,
            'updated_at'        => $this->updated_at ? $this->updated_at->toDateTimeString() : null,
            'price'             => $this->price,
            'is_enabled'        => $this->is_enabled,
            'categories'        => CategoryResource::collection($this->whenLoaded('categories')),
            'images'            => ProductImageResource::collection($this->whenLoaded('images')),
            'sets'              => ProductSetResource::collection($this->whenLoaded('sets')),
            'materials'         => MaterialResource::collection($this->whenLoaded('materials')),
            'is_hidden'         => $this->is_hidden,
            'hidden_at'         => $this->hidden_at ?  $this->hidden_at->toDateTimeString() :null,
        ];
    }
}
