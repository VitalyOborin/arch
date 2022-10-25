<?php

declare(strict_types=1);

namespace Acme\Shared\Domain\Aggregate;

abstract class AggregateRoot
{
    protected array $domainEvents;

    public function addDomainEvent(DomainEventInterface $event): self
    {
        $this->domainEvents[] = $event;

        return $this;
    }

    public function getDomainEvents(): array
    {
        $domainEvents = $this->domainEvents;
        $this->domainEvents = [];

        return $domainEvents;
    }
}
