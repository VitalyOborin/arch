<?php

declare(strict_types=1);

namespace Acme\Product\Domain\Service;

use Acme\Product\Domain\Entity\Product;
use Acme\Product\Domain\Event\ProductCreateDomainEvent;
use Acme\Product\Domain\Repository\ProductRepositoryInterface;
use Acme\Product\Domain\ValueObject\Price;
use Acme\Shared\Domain\Bus\Event\DomainEventDispatcherInterface;
use Exception;

final class ProductCreator
{
    public function __construct(
        private readonly DomainEventDispatcherInterface $dispatcher,
        private readonly ProductRepositoryInterface $repository,
    ) {
    }

    public function __invoke(string $alias, string $name, int $price = 0): Product
    {
        $product = new Product();
        $product->setAlias($alias);
        $product->setName($name);
        $product->setPrice(new Price($price, 'USD')); // todo currency

        try {
            $this->repository->add($product);
        } catch (Exception $exception) {
            // todo domain exception processing
        }

        $this->dispatcher->dispatch(new ProductCreateDomainEvent($product), ProductCreateDomainEvent::NAME);
        return $product;
    }
}
