<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\Money;

class ProductEntity
{
    public function __construct(public int $id, public string $name, public Money $price, public int $stock) {}

    public function ensureStock(int $quantity): void
    {
        if ($quantity > $this->stock) {
            throw new \DomainException('Insufficient stock');
        }
    }
}
