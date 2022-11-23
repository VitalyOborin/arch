<?php

declare(strict_types=1);

namespace Acme\Product\Domain\Service;

use Acme\Product\Domain\Entity\Product;
use Acme\Product\Domain\Event\PriceSetDomainEvent;
use Acme\Product\Domain\Repository\ProductRepositoryInterface;
use Acme\Product\Domain\ValueObject\Price;
use Acme\Shared\Domain\Bus\Event\DomainEventDispatcherInterface;

final class PriceSetter
{
    public function __construct(
        private readonly DomainEventDispatcherInterface $eventDispatcher,
        private readonly ProductRepositoryInterface $repository,
    ) {
    }

    public function __invoke(Product $product, Price $price): void
    {
        $this->repository->setPrice($product, $price);
        $this->eventDispatcher->dispatch(new PriceSetDomainEvent($product, $price), PriceSetDomainEvent::NAME);
    }
}
