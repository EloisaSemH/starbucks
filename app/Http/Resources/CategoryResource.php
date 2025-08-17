<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request, bool $brief = false)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
        ];

        if ($brief) {
            return $data;
        }

        return array_merge($data, [
            'products_count' => $this->when(isset($this->products_count), $this->products_count),
            'products' => ProductResource::collection($this->whenLoaded('products')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
    }
}
