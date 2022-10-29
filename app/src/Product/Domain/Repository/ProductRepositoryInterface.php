<?php

declare(strict_types=1);

namespace Acme\Product\Domain\Repository;

use Acme\Product\Domain\Entity\Product;
use Acme\Product\Domain\ValueObject\Price;

interface ProductRepositoryInterface
{
    public function add(Product $product): void;

    public function findOneByAlias(string $alias): ?Product;

    public function setPrice(Product $product, Price $price): void;
}
