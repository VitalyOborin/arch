<?php

declare(strict_types=1);

namespace Acme\Shared\Infrastructure\Bus\Event;

use Acme\Shared\Domain\Bus\Event\DomainEventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class DomainEventDispatcher extends EventDispatcher implements DomainEventDispatcherInterface
{
    public function __construct(iterable $subscribers)
    {
        parent::__construct();

        foreach ($subscribers as $subscriber) {
            $this->addSubscriber($subscriber);
        }
    }
}
