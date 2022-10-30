<?php

declare(strict_types=1);

namespace Acme\Product\Application\Command\Create;

use Acme\Shared\Domain\Bus\Command\CommandInterface;

class ProductCreateCommand implements CommandInterface
{
    public function __construct(
        private readonly string $alias,
        private readonly string $name,
        private readonly int $price,
    ) {
    }

    public function getAlias(): string
    {
        return $this->alias;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }
}
