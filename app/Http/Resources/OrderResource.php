<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'total_cents' => $this->total_cents,
            'paid_cents' => $this->paid_cents,
            'change_cents' => $this->change_cents,
            'status' => $this->status,
            'items' => $this->items->map(
                fn($item) => [
                    'product' => [
                        'id' => $item->product->id,
                        'name' => $item->product->name,
                    ],
                    'quantity' => $item->quantity,
                    'unit_price_cents' => $item->unit_price_cents,
                    'line_total_cents' => $item->line_total_cents,
                    'extras' => $item->extras->map(
                        fn($extra) => [
                            'id' => $extra->extra->id,
                            'name' => $extra->extra->name,
                            'price_cents' => $extra->price_cents,
                        ],
                    ),
                ],
            ),
        ];
    }
}
