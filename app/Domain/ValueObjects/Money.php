<?php

namespace App\Domain\ValueObjects;

final class Money
{
    public function __construct(private int $cents)
    {
        if ($cents < 0) {
            throw new \InvalidArgumentException('Money cannot be negative');
        }
    }

    public static function fromInt(int $cents): self
    {
        return new self($cents);
    }
    public static function fromFloat(float $amount): self
    {
        return new self((int) round($amount * 100));
    }

    public function add(Money $other): self
    {
        return new self($this->cents + $other->cents);
    }
    public function multiply(int $quantity): self
    {
        return new self($this->cents * $quantity);
    }
    public function greaterThanOrEqual(Money $other): bool
    {
        return $this->cents >= $other->cents;
    }
    public function minus(Money $other): self
    {
        return new self(max(0, $this->cents - $other->cents));
    }

    public function cents(): int
    {
        return $this->cents;
    }
    public function format(string $currency = '€'): string
    {
        return $currency . number_format($this->cents / 100, 2);
    }
}
