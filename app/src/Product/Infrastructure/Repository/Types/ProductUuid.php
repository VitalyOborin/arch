<?php

declare(strict_types=1);

namespace Acme\Product\Infrastructure\Repository\Types;

use Acme\Product\Domain\ValueObject\ProductId;
use Doctrine\ODM\MongoDB\Types\ClosureToPHP;
use Doctrine\ODM\MongoDB\Types\Type;

class ProductUuid extends Type
{
    use ClosureToPHP;

    public function convertToPHPValue($value): ProductId
    {
        return new ProductId($value);
    }

    public function convertToDatabaseValue($value): string
    {
        /* @var ProductId|string $value */
        return $value instanceof ProductId ? $value->getValue() : $value;
    }
}
