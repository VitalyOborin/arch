<?php

declare(strict_types=1);

namespace Acme\Shared\Infrastructure\Bus\Kafka;

use Psr\Log\LoggerInterface;
use RdKafka;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Messenger\Transport\TransportFactoryInterface;
use Symfony\Component\Messenger\Transport\TransportInterface;

class KafkaTransportFactory implements TransportFactoryInterface
{
    public const SCHEMA = 'rdkafka';

    public function __construct(protected LoggerInterface $logger)
    {
    }

    public function createTransport(string $dsn, array $options, SerializerInterface $serializer = null): TransportInterface
    {
        return new KafkaTransport(new KafkaConf($dsn, $options, $serializer, $this->logger));
    }

    public function supports(string $dsn, array $options): bool
    {
        return class_exists(RdKafka::class) && !in_array(
            false,
            array_map(
                fn ($host) => str_starts_with(
                    $host,
                    self::SCHEMA . '://'
                ),
                explode(',', $dsn)
            ),
            true
        );
    }
}
