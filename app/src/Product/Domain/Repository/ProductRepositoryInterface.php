<?php

declare(strict_types=1);

namespace Acme\Product\Domain\Repository;

use Acme\Product\Domain\Entity\Product;

interface ProductRepositoryInterface
{
    public function add(Product $product): void;

    public function findOneByAlias(string $alias): ?Product;
}
