<?php

declare(strict_types=1);

namespace Acme\Product\Application\Transport\Consumer\TopicProducts;

use Acme\Shared\Domain\Bus\Kafka\KafkaHandlerInterface;
use Acme\Shared\Domain\Bus\Kafka\KafkaMessageInterface;
use Psr\Log\LoggerInterface;

class TopicProductsHandler implements KafkaHandlerInterface
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function __invoke(KafkaMessageInterface $message): void
    {
        $this->logger->notice('topic products message processed');
    }

    public static function getHandledMessages(): iterable
    {
        yield KafkaMessageInterface::class => [
            'from_transport' => 'kafka.products',
        ];
    }
}
