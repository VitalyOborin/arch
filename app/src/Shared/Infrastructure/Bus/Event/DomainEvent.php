<?php

declare(strict_types=1);

namespace Acme\Shared\Infrastructure\Bus\Event;

use Acme\Shared\Domain\Bus\Event\DomainEventInterface;
use Symfony\Contracts\EventDispatcher\Event;

class DomainEvent extends Event implements DomainEventInterface
{
}
