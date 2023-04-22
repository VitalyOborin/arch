<?php

declare(strict_types=1);

namespace Acme\Product\Service;

use Acme\Product\Domain\ProductRepositoryInterface;
use Acme\Product\Domain\Exception\ProductNotFoundException;
use Acme\Product\Domain\Product;

class ProductFinderByAlias
{
    public function __construct(private readonly ProductRepositoryInterface $repository)
    {
    }

    public function find(string $alias): Product
    {
        $product = $this->repository->findByAlias($alias);

        if (null === $product) {
            throw new ProductNotFoundException($alias);
        }

        return $product;
    }
}
