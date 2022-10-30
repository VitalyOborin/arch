<?php

declare(strict_types=1);

namespace Acme\Product\Application\Request\Find;

use Acme\Product\Domain\Exception\UnableToCreateProductException;
use Acme\Product\Domain\Service\ProductFinder;
use Acme\Shared\Domain\Bus\Query\QueryHandlerInterface;

final class ProductFindQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly ProductFinder $productFinder)
    {
    }

    public function __invoke(ProductFindQuery $query): ProductFindResponse
    {
        $product = $this->productFinder->__invoke($query->getAlias());

        if ($product === null) {
            throw new UnableToCreateProductException();
        }

        return new ProductFindResponse($product);
    }
}
