<?php

declare(strict_types=1);

namespace Acme\Product\Infrastructure\Repository\ODM;

use Acme\Product\Domain\Entity\Product;
use Acme\Product\Domain\Repository\ProductRepositoryInterface;
use Doctrine\ODM\MongoDB\DocumentManager;

class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(private readonly DocumentManager $dm)
    {
    }

    public function add(Product $product): void
    {
        $this->dm->persist($product);
        $this->dm->flush();
    }

    public function findOneByAlias(string $alias): ?Product
    {
        /** @var Product|null $product */
        return $this->dm
            ->createQueryBuilder(Product::class)
            ->field('alias')->equals($alias)
            ->getQuery()
            ->getSingleResult();
    }
}
