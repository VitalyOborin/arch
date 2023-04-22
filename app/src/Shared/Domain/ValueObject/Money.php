<?php

declare(strict_types=1);

namespace Acme\Shared\Domain\ValueObject;

use Stringable;

class Money implements Stringable
{
    public function __construct(protected float $value, protected string $currency)
    {
    }

    public function value(): float
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return sprintf('%s %s', $this->value, $this->currency);
    }
}
