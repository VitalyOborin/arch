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
        /** @var $product Product|null */
        $product = $this->dm->createQueryBuilder(Product::class)
            ->field('alias')->equals($alias)
            ->getQuery()
            ->getSingleResult();

        return $product;
    }

    public function save(Product $product): void
    {
        $this->dm->persist($product);
        $this->dm->flush();
    }
}
