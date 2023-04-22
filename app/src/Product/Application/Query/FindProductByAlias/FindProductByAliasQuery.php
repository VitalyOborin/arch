<?php

declare(strict_types=1);

namespace Acme\Product\Application\Query\FindProductByAlias;

use Acme\Shared\Domain\Bus\Query\Query;

class FindProductByAliasQuery implements Query
{
    public function __construct(private readonly string $alias)
    {
    }

    public function alias(): string
    {
        return $this->alias;
    }
}
