<?php

declare(strict_types=1);

namespace Acme\Product\Domain\Exception;

use Exception;
use Throwable;

class ProductNotFoundException extends Exception
{
    protected const MESSAGE = 'Товар не найден';
    protected const CODE = 404;

    public function __construct(string $message = self::MESSAGE, int $code = self::CODE, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
