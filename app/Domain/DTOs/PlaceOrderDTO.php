<?php

namespace App\Domain\DTOs;

final class PlaceOrderDTO
{
    /** @param array<int, array{id: int, quantity: int, extra_ids: int[]}> $products */
    public function __construct(public array $products, public int $paidCents) {}
}
