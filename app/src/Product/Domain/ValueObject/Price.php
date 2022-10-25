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
            throw new InvalidArgumentException('Цена не может быть отрицательной');
        }
        if (mb_strlen($this->currency) !== 3) {
            throw new InvalidArgumentException('Код валюты должен быть из 3 символов');
        }
        if ($this->decimals < 0) {
            throw new InvalidArgumentException('Количество знаков после запятой не может быть меньше 0');
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
