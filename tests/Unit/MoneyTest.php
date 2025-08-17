<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Domain\ValueObjects\Money;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    public function testAddAndMultiply(): void
    {
        $money = Money::fromInt(350);
        self::assertSame(700, $money->multiply(2)->cents());

        $money2 = Money::fromInt(50);
        self::assertSame(400, $money->add($money2)->cents());
    }

    public function testCompareAndSubtract(): void
    {
        $money = Money::fromInt(1000);
        $money2 = Money::fromInt(700);

        self::assertTrue($money->greaterThanOrEqual($money2));
        self::assertFalse($money2->greaterThanOrEqual($money));
        self::assertSame(300, $money->minus($money2)->cents());
    }

    public function testNegativeThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Money(-1);
    }
}