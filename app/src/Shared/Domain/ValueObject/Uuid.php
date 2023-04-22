<?php

declare(strict_types=1);

namespace Acme\Shared\Domain\ValueObject;

use InvalidArgumentException;
use Stringable;
use Symfony\Component\Uid\UuidV4;

class Uuid implements Stringable
{
    public function __construct(protected string $value)
    {
        $this->ensureIsValidUuid($value);
    }

    public static function random(): self
    {
        return new static(UuidV4::v4()->toRfc4122());
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(Uuid $other): bool
    {
        return $this->value() === $other->value();
    }

    public function __toString(): string
    {
        return $this->value();
    }

    private function ensureIsValidUuid(string $uuid): void
    {
        if (!UuidV4::isValid($uuid)) {
            throw new InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', static::class, $uuid));
        }
    }
}
