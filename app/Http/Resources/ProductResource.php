<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => new CategoryResource($this->whenLoaded('category'), true),
            'price_cents' => $this->price_cents,
            'stock' => $this->stock,
            'extras' => ExtraResource::collection($this->whenLoaded('extras')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}