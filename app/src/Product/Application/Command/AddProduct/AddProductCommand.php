<?php

declare(strict_types=1);

namespace Acme\Product\Application\Command\AddProduct;

use Acme\Product\Domain\Entity\Product;
use Acme\Shared\Domain\Bus\Command\CommandInterface;

class AddProductCommand implements CommandInterface
{
    public function __construct(private readonly Product $product)
    {
    }

    public function getProduct(): Product
    {
        return $this->product;
    }
}
