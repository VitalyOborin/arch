<?php

declare(strict_types=1);

namespace Acme\Product\Domain;

use Acme\Shared\Domain\Aggregate\AggregateRoot;
use Acme\Shared\Domain\ValueObject\Money;

class Product extends AggregateRoot
{
    public function __construct(
        private readonly string $id,
        private readonly string $alias,
        private readonly string $name,
        private readonly Money $price
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function alias(): string
    {
        return $this->alias;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function price(): string
    {
        return (string)$this->price;
    }
}
