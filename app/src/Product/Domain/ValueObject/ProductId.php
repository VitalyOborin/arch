<?php

declare(strict_types=1);

namespace Acme\Product\Domain\ValueObject;

use Acme\Shared\Domain\ValueObject\Uuid;

class ProductId extends Uuid
{
    private string $uuid;

    public function __construct(?string $uuid = null)
    {
        $this->uuid = $uuid ?? parent::v4()->uid;
        parent::__construct($this->uuid);
    }

    public function getValue(): string
    {
        return $this->uuid;
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}
