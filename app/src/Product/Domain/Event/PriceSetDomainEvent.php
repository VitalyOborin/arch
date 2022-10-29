<?php

declare(strict_types=1);

namespace Acme\Product\Domain\Event;

use Acme\Product\Domain\Entity\Product;
use Acme\Product\Domain\ValueObject\Price;
use Acme\Shared\Domain\Bus\Event\DomainEventAbstract;

final class PriceSetDomainEvent extends DomainEventAbstract
{
    public const NAME = 'product.price.set';

    public function __construct(private readonly Product $product, private readonly Price $price)
    {
        parent::__construct();
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }
}
