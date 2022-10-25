<?php

declare(strict_types=1);

namespace Acme\Product\Domain\Exception;

use Exception;
use Throwable;

class ProductAlreadyExistsException extends Exception
{
    protected const MESSAGE = 'Товар уже существует';
    protected const CODE = 400;

    public function __construct(string $message = self::MESSAGE, int $code = self::CODE, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
