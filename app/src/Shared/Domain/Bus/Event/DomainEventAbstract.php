<?php

declare(strict_types=1);

namespace Acme\Shared\Domain\Bus\Event;

use DateTimeImmutable;

abstract class DomainEventAbstract implements DomainEventInterface
{
    private DateTimeImmutable $occurredOn;
    private string $eventClassName;

    public function __construct()
    {
        $this->occurredOn = new DateTimeImmutable();
        $this->eventClassName = static::class;
    }

    public function getOccurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }

    public function getEventClassName(): string
    {
        return $this->eventClassName;
    }
}
