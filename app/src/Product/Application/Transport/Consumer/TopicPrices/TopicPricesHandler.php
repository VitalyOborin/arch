<?php

declare(strict_types=1);

namespace Acme\Product\Application\Transport\Consumer\TopicPrices;

use Acme\Product\Domain\Service\PriceSetter;
use Acme\Product\Domain\Service\ProductFinder;
use Acme\Product\Domain\ValueObject\Price;
use Acme\Shared\Domain\Bus\Kafka\KafkaHandlerInterface;
use Acme\Shared\Domain\Bus\Kafka\KafkaMessageInterface;
use Psr\Log\LoggerInterface;

class TopicPricesHandler implements KafkaHandlerInterface
{
    public function __construct(
        private readonly PriceSetter $priceSetter,
        private readonly ProductFinder $productFinder,
        private readonly LoggerInterface $logger
    ) {
    }

    public function __invoke(KafkaMessageInterface $message): void
    {
        $productAlias = $message->getKey();
        $priceValue = $message->getBody()['price'];
        $currencyValue = $message->getBody()['currency'];
        $price = new Price($priceValue, $currencyValue ?? 'USD');

        $product = $this->productFinder->__invoke($productAlias);
        $this->priceSetter->__invoke($product, $price);

        $this->logger->notice('topic prices message processed');
    }

    public static function getHandledMessages(): iterable
    {
        yield KafkaMessageInterface::class => [
            'from_transport' => 'kafka.prices',
        ];
    }
}
