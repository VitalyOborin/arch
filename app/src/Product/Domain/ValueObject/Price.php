<?php

declare(strict_types=1);

namespace Acme\Product\Domain\ValueObject;

use InvalidArgumentException;

class Price
{
    public function __construct(
        public readonly int $value,
        public readonly string $currency,
        public readonly int $decimals = 2,
    ) {
        if ($this->value < 0) {
            throw new InvalidArgumentException('Price cannot be negative');
        }
        if (mb_strlen($this->currency) !== 3) {
            throw new InvalidArgumentException('Currency code must be 3 characters long');
        }
        if ($this->decimals < 0) {
            throw new InvalidArgumentException('Number of decimal places cannot be less than 0');
        }
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getDecimals(): int
    {
        return $this->decimals;
    }
}
