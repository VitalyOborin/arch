<?php

declare(strict_types=1);

namespace Acme\Shared\Domain\Bus\Event;

use DateTimeImmutable;

abstract class DomainEventAbstract implements DomainEventInterface
{
    private DateTimeImmutable $occurredOn;

    public function __construct()
    {
        $this->occurredOn = new DateTimeImmutable();
    }

    public function getOccurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }
}
