<?php

declare(strict_types=1);

namespace Acme\Product\Application\Query;

use Acme\Shared\Domain\Bus\Query\Response;

class ProductResponse implements Response
{
    public function __construct(
        private readonly string $id,
        private readonly string $alias,
        private readonly string $name,
        private readonly string $price,
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function alias(): string
    {
        return $this->alias;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function price(): string
    {
        return $this->price;
    }
}
