<?php

declare(strict_types=1);

namespace Acme\Product\Infrastructure\Repository;

use Acme\Product\Domain\Product;
use Acme\Product\Domain\ProductRepositoryInterface;
use Acme\Shared\Infrastructure\Mongo\MongoRepository;

class MongoProductRepository extends MongoRepository implements ProductRepositoryInterface
{

    public function findByAlias(string $alias): ?Product
    {
        return $this->documentManager()->createQueryBuilder(Product::class)
            ->field('alias')->equals($alias)
            ->getQuery()
            ->getSingleResult();
    }
}
