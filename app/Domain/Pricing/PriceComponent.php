<?php

namespace App\Domain\Pricing;

use App\Domain\ValueObjects\Money;

interface PriceComponent
{
    public function total(): Money;
}
