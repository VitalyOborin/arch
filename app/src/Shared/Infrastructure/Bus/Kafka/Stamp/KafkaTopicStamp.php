<?php

declare(strict_types=1);

namespace Acme\Shared\Infrastructure\Bus\Kafka\Stamp;

use Symfony\Component\Messenger\Stamp\NonSendableStampInterface;

class KafkaTopicStamp implements NonSendableStampInterface
{
    public function __construct(private readonly string $topic)
    {
    }

    public function getTopic(): string
    {
        return $this->topic;
    }
}
