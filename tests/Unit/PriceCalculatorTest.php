<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Domain\Pricing\PriceCalculator;
use App\Domain\ValueObjects\Money;
use PHPUnit\Framework\TestCase;

class PriceCalculatorTest extends TestCase
{
    public function testComputeWithExtras(): void
    {
        $calculator = new PriceCalculator();
        $unit = Money::fromInt(350);
        $quantity = 2;
        $extras = [Money::fromInt(50), Money::fromInt(70)];

        $total = $calculator->compute($unit, $quantity, $extras);
        self::assertSame(940, $total->cents());
    }
}
