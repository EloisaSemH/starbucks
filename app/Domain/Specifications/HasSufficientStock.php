<?php

namespace App\Domain\Specifications;

final class HasSufficientStock
{
    public function __construct(private int $available) {}

    public function isSatisfiedBy(int $requested): bool
    {
        return $this->available >= $requested;
    }
}
