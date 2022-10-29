<?php

declare(strict_types=1);

namespace Acme\Product\Application\Command\SetPrice;

use Acme\Shared\Domain\Bus\Command\CommandInterface;

class SetPriceCommand implements CommandInterface
{
    public function __construct(private readonly string $alias, private readonly int $price)
    {
    }

    public function getAlias(): string
    {
        return $this->alias;
    }

    public function getPrice(): int
    {
        return $this->price;
    }
}
