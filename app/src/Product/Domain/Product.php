<?php

declare(strict_types=1);

namespace Acme\Product\Domain;

use Acme\Product\Domain\ValueObject\Price;
use Acme\Product\Domain\ValueObject\ProductId;
use Acme\Shared\Domain\Aggregate\AggregateRoot;

class Product extends AggregateRoot
{
    public ProductId $id;
    public string $alias;
    public string $name;
    public ?Price $price;

    public function __construct()
    {
        $this->id = new ProductId();
    }

    public function getId(): ProductId
    {
        return $this->id;
    }

    public function setId(ProductId $id): void
    {
        $this->id = $id;
    }

    public function setAlias(string $alias): void
    {
        $this->alias = $alias;
    }

    public function getAlias(): string
    {
        return $this->alias;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setPrice(Price $price): void
    {
        $this->price = $price;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }
}
