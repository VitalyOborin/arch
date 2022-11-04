<?php

declare(strict_types=1);

namespace Acme\Shared\Domain\Bus\Kafka;

interface KafkaBusInterface
{
    public function dispatch(KafkaMessageInterface $message): void;
}
