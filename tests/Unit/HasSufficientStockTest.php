<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Domain\Specifications\HasSufficientStock;
use PHPUnit\Framework\TestCase;

class HasSufficientStockTest extends TestCase
{
    public function testIsSatisfiedBy(): void
    {
        $specification = new HasSufficientStock(10);
        self::assertTrue($specification->isSatisfiedBy(8));
        self::assertTrue($specification->isSatisfiedBy(10));
        self::assertFalse($specification->isSatisfiedBy(11));
    }
}
