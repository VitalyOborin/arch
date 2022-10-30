<?php

declare(strict_types=1);

namespace Acme\Product\Application\Request\Find;

use Acme\Shared\Domain\Bus\Query\QueryInterface;

final class ProductFindQuery implements QueryInterface
{
    public function __construct(private readonly string $alias)
    {
    }

    public function getAlias(): string
    {
        return $this->alias;
    }
}
