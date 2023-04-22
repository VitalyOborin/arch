<?php

declare(strict_types=1);

namespace Acme\Product\Application\Query\FindProductByAlias;

use Acme\Product\Application\Query\ProductResponse;
use Acme\Product\Domain\Exception\ProductNotFoundException;
use Acme\Product\Domain\ProductRepositoryInterface;
use Exception;

class FindProductByAliasFinder
{
    public function __construct(private readonly ProductRepositoryInterface $repository)
    {
    }

    public function find(string $alias): ProductResponse
    {
        $product = $this->repository->findByAlias($alias);

        if (null === $product) {
            throw new ProductNotFoundException($alias);
        }

        return new ProductResponse(
            $product->id(),
            $product->alias(),
            $product->name(),
            $product->price()
        );
    }
}
