<?php

declare(strict_types=1);

namespace Acme\Product\Application\Request\FindProduct;

use Acme\Shared\Domain\Bus\Query\QueryInterface;

final class FindProductQuery implements QueryInterface
{
    public function __construct(private readonly string $alias)
    {
    }

    public function getAlias(): string
    {
        return $this->alias;
    }
}
