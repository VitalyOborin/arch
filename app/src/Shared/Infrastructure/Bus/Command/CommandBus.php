<?php

declare(strict_types=1);

namespace Acme\Shared\Infrastructure\Bus\Command;

use Acme\Shared\Domain\Bus\Command\CommandBusInterface;
use Acme\Shared\Domain\Bus\Command\CommandInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class CommandBus implements CommandBusInterface
{
    public function __construct(private readonly MessageBusInterface $messageBus)
    {
    }

    public function dispatch(CommandInterface $command): void
    {
        $this->messageBus->dispatch($command)->last(HandledStamp::class);
    }
}
