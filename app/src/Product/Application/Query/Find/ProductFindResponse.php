<?php

declare(strict_types=1);

namespace Acme\Product\Application\Query\Find;

use Acme\Product\Domain\Entity\Product;
use Acme\Shared\Domain\Bus\Query\ResponseInterface;

final class ProductFindResponse implements ResponseInterface
{
    public function __construct(private readonly Product $product)
    {
    }

    public function getResult(): Product
    {
        return $this->product;
    }
}
