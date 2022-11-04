<?php

declare(strict_types=1);

namespace Acme\Shared\Infrastructure\Bus\Kafka;

use Acme\Shared\Infrastructure\Bus\Kafka\Stamp\KafkaMessageStamp;
use Acme\Shared\Infrastructure\Bus\Kafka\Stamp\KafkaTopicStamp;
use LogicException;
use Psr\Log\LoggerInterface;
use RdKafka\KafkaConsumer as RdKafkaConsumer;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\TransportException;
use Symfony\Component\Messenger\Stamp\TransportMessageIdStamp;
use Symfony\Component\Messenger\Transport\Receiver\ReceiverInterface;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

class KafkaConsumer implements ReceiverInterface
{
    private SerializerInterface $serializer;
    private LoggerInterface $logger;
    private RdKafkaConsumer $consumer;
    private bool $subscribed = false;

    public function __construct(private readonly KafkaConf $conf)
    {
        $this->serializer = $this->conf->getSerializer();
        $this->logger = $this->conf->getLogger();
    }

    public function get(): iterable
    {
        $message = $this->getSubscribedConsumer()->consume($this->conf->getReceiveTimeout());

        switch ($message->err) {
            case RD_KAFKA_RESP_ERR_NO_ERROR:
                $this->logger->info(sprintf(
                    'Kafka: Message %s %s %s received ',
                    $message->topic_name,
                    $message->partition,
                    $message->offset
                ));

                $envelope = $this->serializer->decode([
                    'key' => $message->key,
                    'topic' => $message->topic_name,
                    'body' => $message->payload,
                    'headers' => $message->headers ?? [],
                    'offset' => $message->offset,
                    'timestamp' => $message->timestamp,
                ]);

                return [
                    $envelope
                        ->with(new KafkaMessageStamp($message))
                        ->with(new KafkaTopicStamp($message->topic_name))
                        ->with(new TransportMessageIdStamp($message->key))
                ];
            case RD_KAFKA_RESP_ERR__PARTITION_EOF:
                $this->logger->info('Kafka: Partition EOF reached. Waiting for next message ...');
                break;
            case RD_KAFKA_RESP_ERR__TIMED_OUT:
                $this->logger->debug('Kafka: Consumer timeout.');
                break;
            case RD_KAFKA_RESP_ERR__TRANSPORT:
                $this->logger->debug('Kafka: Broker transport failure.');
                break;
            default:
                throw new TransportException($message->errstr(), $message->err);
        }

        return [];
    }

    public function ack(Envelope $envelope): void
    {
        $stamp = $envelope->last(TransportMessageIdStamp::class);
        if (!$stamp instanceof TransportMessageIdStamp) {
            throw new LogicException('No TransportMessageIdStamp found on the Envelope.');
        }

        $this->consumer->commit(
            $envelope->last(KafkaMessageStamp::class)->getMessage()
        );
    }

    public function reject(Envelope $envelope): void
    {
        /*$stamp = $envelope->last(TransportMessageIdStamp::class);
        if (!$stamp instanceof TransportMessageIdStamp) {
            throw new \LogicException('No TransportMessageIdStamp found on the Envelope.');
        }*/
    }

    private function getSubscribedConsumer(): RdKafkaConsumer
    {
        $consumer = $this->getConsumer();

        if (false === $this->subscribed) {
            $this->logger->info('Partition assignment...');
            $consumer->subscribe([$this->conf->getTopic()]);

            $this->subscribed = true;
        }

        return $consumer;
    }

    private function getConsumer(): RdKafkaConsumer
    {
        return $this->consumer ?? $this->consumer = new RdKafkaConsumer($this->conf->getConsumerConf());
    }
}
