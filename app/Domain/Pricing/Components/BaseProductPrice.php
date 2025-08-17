<?php

namespace App\Domain\Pricing\Components;

use App\Domain\Pricing\PriceComponent;
use App\Domain\ValueObjects\Money;

final class BaseProductPrice implements PriceComponent
{
    public function __construct(private Money $unit, private int $quantity) {}

    public function total(): Money
    {
        return $this->unit->multiply($this->quantity);
    }
}
