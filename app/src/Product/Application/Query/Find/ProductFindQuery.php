<?php

declare(strict_types=1);

namespace Acme\Product\Application\Query\Find;

use Acme\Shared\Domain\Bus\Query\QueryInterface;

class ProductFindQuery implements QueryInterface
{
    public function __construct(private readonly string $alias)
    {
    }

    public function getAlias(): string
    {
        return $this->alias;
    }
}
