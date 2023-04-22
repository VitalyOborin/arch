<?php

declare(strict_types=1);

namespace Acme\Product\Domain;

interface ProductRepositoryInterface
{
    public function findByAlias(string $alias): ?Product;
}
