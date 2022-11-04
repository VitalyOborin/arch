<?php

declare(strict_types=1);

namespace Acme\Shared\Domain\Bus\Kafka;

interface KafkaMessageInterface
{
    public function getKey(): string;

    public function getTopic(): string;

    public function getBody(): array;
}
