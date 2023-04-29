<?php

declare(strict_types=1);

namespace Acme\Product\Application\Query\FindProductByAlias;

use Acme\Product\Application\Query\ProductResponse;
use Acme\Product\Service\ProductFinder;
use Acme\Shared\Domain\Bus\Query\QueryHandler;

class FindProductByAliasQueryHandler implements QueryHandler
{
    public function __construct(private readonly ProductFinder $finder)
    {
    }

    public function __invoke(FindProductByAliasQuery $query): ProductResponse
    {
        $product = $this->finder->findByAlias($query->alias());

        return new ProductResponse(
            $product->id(),
            $product->alias(),
            $product->name(),
            $product->price(),
        );
    }
}
