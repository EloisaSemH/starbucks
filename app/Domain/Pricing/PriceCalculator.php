<?php

namespace App\Domain\Pricing;

use App\Domain\ValueObjects\Money;
use App\Domain\Pricing\Components\BaseProductPrice;
use App\Domain\Pricing\Components\ExtraPrice;

final class PriceCalculator
{
    /** @param Money[] $extrasUnitPrices */
    public function compute(Money $productUnit, int $quantity, array $extrasUnitPrices): Money
    {
        $base = new BaseProductPrice($productUnit, $quantity);
        $withExtras = new ExtraPrice($base, $extrasUnitPrices, $quantity);
        return $withExtras->total();
    }
}
