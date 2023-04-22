<?php

declare(strict_types=1);

namespace Acme\Shared\Domain\Bus\Event;

interface DomainEventSubscriberInterface
{
    public static function subscribedTo(): array;
}
