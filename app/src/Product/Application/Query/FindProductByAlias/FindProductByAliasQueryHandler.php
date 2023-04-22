<?php

declare(strict_types=1);

namespace Acme\Product\Application\Query\FindProductByAlias;

use Acme\Product\Application\Query\ProductResponse;
use Acme\Shared\Domain\Bus\Query\QueryHandler;

class FindProductByAliasQueryHandler implements QueryHandler
{
    public function __construct(private readonly FindProductByAliasFinder $finder)
    {
    }

    public function __invoke(FindProductByAliasQuery $query): ProductResponse
    {
        return $this->finder->find($query->alias());
    }
}
