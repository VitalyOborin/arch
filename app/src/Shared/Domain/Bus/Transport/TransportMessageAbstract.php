<?php

declare(strict_types=1);

namespace Acme\Shared\Domain\Bus\Transport;

use VO\KafkaTransport\Messenger\KafkaMessageInterface;

abstract class TransportMessageAbstract implements KafkaMessageInterface
{
    private const TOPIC = '';

    protected string $key;
    protected array $body;
    protected int $offset;
    protected int $timestamp;

    public function getKey(): string
    {
        return $this->key;
    }

    public function getTopic(): string
    {
        return self::TOPIC;
    }

    public function getBody(): array
    {
        return $this->body;
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
