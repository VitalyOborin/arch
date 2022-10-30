<?php

declare(strict_types=1);

namespace Acme\Shared\Domain\Bus\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

abstract class DomainEventSubscriberAbstract implements DomainEventSubscriberInterface, EventSubscriberInterface
{
    abstract public static function getSubscribedEvents(): array;
}
