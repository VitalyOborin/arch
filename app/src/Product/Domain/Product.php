<?php

declare(strict_types=1);

namespace Acme\Product\Domain;

use Acme\Product\Domain\ValueObject\Price;
use Acme\Shared\Domain\Aggregate\AggregateRoot;

class Product extends AggregateRoot
{
    public function __construct(
        private readonly string $id,
        private readonly string $alias,
        private readonly string $name,
        private readonly Price $price
    ) {
    }

    public static function create(string $id, string $alias, string $name, Price $price): self
    {
        return new self($id, $alias, $name, $price); // todo es
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
