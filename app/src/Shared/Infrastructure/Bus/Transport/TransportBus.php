<?php

declare(strict_types=1);

namespace Acme\Shared\Infrastructure\Bus\Transport;

use Acme\Shared\Domain\Bus\Transport\TransportBusInterface;
use Acme\Shared\Domain\Bus\Transport\TransportMessageInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class TransportBus implements TransportBusInterface
{
    public function __construct(private readonly MessageBusInterface $transportBus)
    {
    }

    public function dispatch(TransportMessageInterface $message): void
    {
        $this->transportBus
            ->dispatch($message)
            ->last(HandledStamp::class); // KafkaMessageStamp::class
    }
}
