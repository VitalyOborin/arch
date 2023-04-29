<?php

declare(strict_types=1);

namespace Acme\Product\Application\Command\Create;

use Acme\Product\Domain\ValueObject\Price;
use Acme\Shared\Domain\Bus\Command\Command;

class CreateCommand implements Command
{
    public function __construct(
        private readonly string $id,
        private readonly string $alias,
        private readonly string $name,
        private readonly Price $price,
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

    public function price(): Price
    {
        return $this->price;
    }
}
