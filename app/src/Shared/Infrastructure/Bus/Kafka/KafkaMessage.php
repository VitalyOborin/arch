<?php

declare(strict_types=1);

namespace Acme\Shared\Infrastructure\Bus\Kafka;

use Acme\Shared\Domain\Bus\Kafka\KafkaMessageInterface;

class KafkaMessage implements KafkaMessageInterface
{
    public function __construct(
        protected string $key,
        protected string $topic,
        protected array $body,
        protected array $headers = [],
        protected int $offset = 0,
        protected int $timestamp = 0
    ) {
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getTopic(): string
    {
        return $this->topic;
    }

    public function getBody(): array
    {
        return $this->body;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }
}
