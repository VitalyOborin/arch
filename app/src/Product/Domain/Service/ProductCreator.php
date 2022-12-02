<?php

declare(strict_types=1);

namespace Acme\Product\Domain\Service;

use Acme\Product\Domain\Event\ProductCreateDomainEvent;
use Acme\Product\Domain\Exception\ProductAlreadyExistsException;
use Acme\Product\Domain\Product;
use Acme\Product\Domain\Repository\ProductRepositoryInterface;
use Acme\Product\Domain\ValueObject\Price;
use Acme\Shared\Domain\Bus\Event\DomainEventDispatcherInterface;
use Psr\Log\LoggerInterface;

class ProductCreator
{
    public function __construct(
        private readonly DomainEventDispatcherInterface $eventDispatcher,
        private readonly ProductRepositoryInterface $repository,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function __invoke(string $alias, string $name, int $price = 0): Product
    {
        $product = new Product();
        $product->setAlias($alias);
        $product->setName($name);
        $product->setPrice(new Price($price, 'USD')); // todo currency

        if ($this->repository->findOneByAlias($alias)) {
            throw new ProductAlreadyExistsException(); // todo move to repository
        }

        $this->repository->add($product);

        $this->logger->info(sprintf('Added product with id: %s', $product->getId()));

        $this->eventDispatcher->dispatch(new ProductCreateDomainEvent($product), ProductCreateDomainEvent::NAME);

        return $product;
    }
}
