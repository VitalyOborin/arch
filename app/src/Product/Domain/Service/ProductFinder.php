<?php

declare(strict_types=1);

namespace Acme\Product\Domain\Service;

use Acme\Product\Domain\Event\ProductFindDomainEvent;
use Acme\Product\Domain\Product;
use Acme\Product\Domain\Repository\ProductRepositoryInterface;
use Acme\Shared\Domain\Bus\Event\DomainEventDispatcherInterface;

final class ProductFinder
{
    public function __construct(
        private readonly DomainEventDispatcherInterface $dispatcher,
        private readonly ProductRepositoryInterface $repository,
    ) {
    }

    public function __invoke(string $alias): ?Product
    {
        $product = $this->repository->findOneByAlias($alias);
        $this->dispatcher->dispatch(new ProductFindDomainEvent($product), ProductFindDomainEvent::NAME);

        return $product;
    }
}
