<?php

declare(strict_types=1);

namespace Acme\Shared\Domain\Bus\Event;

use Acme\Shared\Domain\ValueObject\Uuid;
use DateTimeImmutable;

abstract class DomainEvent
{
    private readonly string $eventId;
    private readonly string $occurredOn;

    public function __construct(private readonly string $aggregateId, string $eventId = null, string $occurredOn = null)
    {
        $this->eventId    = $eventId ?: Uuid::random()->value();
        $this->occurredOn = $occurredOn ?: new DateTimeImmutable();
    }

    abstract public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): self;

    abstract public static function eventName(): string;

    abstract public function toPrimitives(): array;

    public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    public function eventId(): string
    {
        return $this->eventId;
    }

    public function occurredOn(): string
    {
        return $this->occurredOn;
    }
}
