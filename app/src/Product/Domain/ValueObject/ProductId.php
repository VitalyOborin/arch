<?php

declare(strict_types=1);

namespace Acme\Product\Domain\ValueObject;

use InvalidArgumentException;

use const PHP_INT_MAX;

class ProductId
{
    public function __construct(private readonly int $productId)
    {
        if ($this->productId < 0) {
            throw new InvalidArgumentException('Идентификатор не может быть отрицательным');
        }
        if ($this->productId > PHP_INT_MAX) {
            throw new InvalidArgumentException('Значение идентификатора слишком большое');
        }
    }

    public function getValue(): int
    {
        return $this->productId;
    }
}
