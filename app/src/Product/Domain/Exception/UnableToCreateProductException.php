<?php

declare(strict_types=1);

namespace Acme\Product\Domain\Exception;

use Exception;
use Throwable;

class UnableToCreateProductException extends Exception
{
    protected const MESSAGE = 'Не получилось создать товар';
    protected const CODE = 500;

    public function __construct(string $message = self::MESSAGE, int $code = self::CODE, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
