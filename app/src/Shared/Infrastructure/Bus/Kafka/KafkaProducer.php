<?php

declare(strict_types=1);

namespace Acme\Shared\Infrastructure\Bus\Kafka;

use RdKafka\Producer as RdKafkaProducer;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Sender\SenderInterface;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

class KafkaProducer implements SenderInterface
{
    private SerializerInterface $serializer;
    private RdKafkaProducer $producer;
    private string $topic;

    public function __construct(private readonly KafkaConf $conf)
    {
        $this->serializer = $this->conf->getSerializer();
        $this->topic = $this->conf->getTopic();
    }

    public function send(Envelope $envelope): Envelope
    {
        $encodedMessage = $this->serializer->encode($envelope);

        // $this->topic->produce(RD_KAFKA_PARTITION_UA, 0, $encodedMessage['body'], $encodedMessage['key']);
        $this->topic->producev(
            RD_KAFKA_PARTITION_UA,
            0,
            $encodedMessage['body'],
            $encodedMessage['key'] ?? null,
            $encodedMessage['headers'] ?? null,
            $encodedMessage['timestamp_ms'] ?? null
        );
        $this->producer->poll(0);

        return $envelope;
    }

    private function getProducer(): RdKafkaProducer
    {
        return $this->producer ?? $this->producer = new RdKafkaProducer($this->conf->getProducerConf());
    }
}
