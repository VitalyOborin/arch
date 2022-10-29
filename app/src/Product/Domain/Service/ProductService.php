<?php

declare(strict_types=1);

namespace Acme\Product\Domain\Service;

use Acme\Product\Domain\Entity\Product;
use Acme\Product\Domain\Event\PriceSetDomainEvent;
use Acme\Product\Domain\Repository\ProductRepositoryInterface;
use Acme\Product\Domain\ValueObject\Price;
use Acme\Shared\Infrastructure\Bus\Event\DomainEventDispatcher;

class ProductService
{
    public function __construct(
        private readonly DomainEventDispatcher $dispatcher,
        private readonly ProductRepositoryInterface $repository,
    ) {
    }

    public function setPrice(Product $product, Price $price): void
    {
        $this->repository->setPrice($product, $price);
        $this->dispatcher->dispatch(new PriceSetDomainEvent($product, $price), PriceSetDomainEvent::NAME);
    }
}
