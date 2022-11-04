<?php

declare(strict_types=1);

namespace Acme\Shared\Infrastructure\Bus\Kafka;

use Psr\Log\LoggerInterface;
use RdKafka\Conf;
use RdKafka\KafkaConsumer;
use RdKafka\Producer;
use Symfony\Component\Messenger\Transport\Serialization\PhpSerializer;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

class KafkaConf
{
    public function __construct(
        private string $dsn,
        private readonly array $options,
        private readonly SerializerInterface $serializer,
        private readonly LoggerInterface $logger
    ) {
        $this->dsn = str_replace(KafkaTransportFactory::SCHEMA.'://', '', $dsn);
    }

    public function getTopic(): string
    {
        return $this->options['topic'];
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getSerializer(): SerializerInterface
    {
        return $this->serializer  ?? new PhpSerializer();
    }

    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    public function getProducerConf(): Conf
    {
        $producerConf = new Conf();
        $producerConf->set('bootstrap.servers', $this->dsn);
        $producerConf->set('log_level', (string)LOG_DEBUG);
        $producerConf->set('debug', 'all');

        $producerConf->setLogCb(
            function (Producer $producer, int $level, string $facility, string $message): void {
                /*$this->logger->info(
                    sprintf(
                        'KafkaTransport producer, topics %s, level %d, facility %s, message: %s',
                        'TOPIC', //implode(', ', $producer->getMetadata(true, $producer->newTopic(), )->getTopics()),
                        $level,
                        $facility,
                        $message
                    )
                );*/
            }
        );

        return $producerConf;
    }

    public function getConsumerConf(): Conf
    {
        $consumerConf = new Conf();
        $consumerConf->set('bootstrap.servers', $this->dsn);
        $consumerConf->set('group.id', 'grousdfsdf'); // $this->options['group_id']
        $consumerConf->set('enable.partition.eof', 'true');
        $consumerConf->set('auto.offset.reset', 'earliest');
        $consumerConf->set('log_level', (string)LOG_DEBUG);
        $consumerConf->set('debug', 'all');

        $consumerConf->setLogCb(
            function (KafkaConsumer $consumer, int $level, string $facility, string $message): void {
                if ($facility !== 'CONSUME') {
                    return;
                }
                $this->logger->info(
                    sprintf(
                        'KafkaTransport consumer, topics %s, level %d, facility %s, message: %s',
                        implode(', ', $consumer->getSubscription()),
                        $level,
                        $facility,
                        $message
                    )
                );
            }
        );

        return $consumerConf;
    }

    public function getReceiveTimeout(): int
    {
        return $this->options['receiveTimeout'];
    }
}
