<?php

declare(strict_types=1);

namespace Acme\Product\Service;

use Acme\Product\Domain\Product;
use Acme\Product\Domain\ProductRepositoryInterface;
use Acme\Product\Domain\ValueObject\Price;

class ProductCreator
{
    public function __construct(private readonly ProductRepositoryInterface $repository)
    {
    }

    public function __invoke(string $id, string $alias, string $name, Price $price): void
    {
        $product = Product::create($id, $alias, $name, $price);
        $this->repository->save($product);
    }
}
