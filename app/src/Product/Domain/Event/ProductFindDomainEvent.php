<?php

declare(strict_types=1);

namespace Acme\Product\Domain\Event;

use Acme\Product\Domain\Entity\Product;
use Acme\Shared\Domain\Bus\Event\DomainEventAbstract;

final class ProductFindDomainEvent extends DomainEventAbstract
{
    public const NAME = 'product.find';

    public function __construct(private readonly Product $product)
    {
        parent::__construct();
    }

    public function getProduct(): Product
    {
        return $this->product;
    }
}
