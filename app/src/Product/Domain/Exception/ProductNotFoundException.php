<?php

declare(strict_types=1);

namespace Acme\Product\Domain\Exception;

use Acme\Shared\Domain\Exception\DomainError;

class ProductNotFoundException extends DomainError
{
    public function __construct(private readonly string $alias)
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'product_not_found';
    }

    protected function errorMessage(): string
    {
        return sprintf('The product <%s> does not exist', $this->alias);
    }
}
