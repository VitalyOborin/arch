<?php

declare(strict_types=1);

namespace Acme\Shared\Infrastructure\Bus\Kafka;

use LogicException;
use RdKafka\KafkaConsumer as Consumer;
use RdKafka\Producer;
use RdKafka\Topic;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\TransportMessageIdStamp;
use Symfony\Component\Messenger\Transport\Serialization\PhpSerializer;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Messenger\Transport\TransportInterface;

use const LOG_DEBUG;
use const RD_KAFKA_PARTITION_UA;
use const RD_KAFKA_RESP_ERR__PARTITION_EOF;
use const RD_KAFKA_RESP_ERR__TIMED_OUT;

class KafkaTransport implements TransportInterface
{
    private readonly KafkaConsumer $consumer;
    private readonly KafkaProducer $producer;
    private readonly KafkaConf $conf;
    private SerializerInterface $serializer;

    public function __construct(KafkaConf $conf)
    {
        $this->conf = $conf;
        $this->serializer = $conf->getSerializer();
    }

    /**
     * {@inheritDoc}
     */
    public function get(): iterable
    {
        return $this->getConsumer()->get();
    }

    /**
     * {@inheritDoc}
     */
    public function ack(Envelope $envelope): void
    {
        $this->getConsumer()->ack($envelope);
    }

    /**
     * {@inheritDoc}
     */
    public function reject(Envelope $envelope): void
    {
        $this->getConsumer()->reject($envelope);
    }

    /**
     * {@inheritDoc}
     */
    public function send(Envelope $envelope): Envelope
    {
        return $this->getProducer()->send($envelope);
    }

    private function getConsumer(): KafkaConsumer
    {
        return $this->consumer ?? $this->consumer = new KafkaConsumer($this->conf);
    }

    private function getProducer(): KafkaProducer
    {
        return $this->producer ?? $this->producer = new KafkaProducer($this->conf);
    }
}
