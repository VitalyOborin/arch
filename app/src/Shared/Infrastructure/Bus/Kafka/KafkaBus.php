<?php

declare(strict_types=1);

namespace Acme\Shared\Infrastructure\Bus\Kafka;

use Acme\Shared\Domain\Bus\Kafka\KafkaBusInterface;
use Acme\Shared\Domain\Bus\Kafka\KafkaMessageInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class KafkaBus implements KafkaBusInterface
{

    public function __construct(private readonly MessageBusInterface $kafkaBus)
    {
    }

    public function dispatch(KafkaMessageInterface $message): void
    {
        $this->kafkaBus
            ->dispatch($message)
            ->last(HandledStamp::class); // KafkaMessageStamp::class
    }
}
