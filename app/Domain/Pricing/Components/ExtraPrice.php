<?php

namespace App\Domain\Pricing\Components;

use App\Domain\Pricing\PriceComponent;
use App\Domain\ValueObjects\Money;

final class ExtraPrice implements PriceComponent
{
    /** @param Money[] $extrasUnitPrices */
    public function __construct(
        private PriceComponent $inner,
        private array $extrasUnitPrices,
        private int $quantity,
    ) {}

    public function total(): Money
    {
        $sum = array_sum(array_map(fn(Money $money) => $money->cents(), $this->extrasUnitPrices));
        $extras = Money::fromInt($sum)->multiply($this->quantity);
        return $this->inner->total()->add($extras);
    }
}
