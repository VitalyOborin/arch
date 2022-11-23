<?php

declare(strict_types=1);

namespace Acme\Product\Application\Transport;

use Acme\Shared\Domain\Bus\Transport\TransportHandlerInterface;
use Acme\Product\Application\Transport\TopicPricesMessage;
use Psr\Log\LoggerInterface;

class TopicPricesHandler implements TransportHandlerInterface
{
    public function __construct(
        // private readonly PriceSetter $priceSetter,
        // private readonly ProductFinder $productFinder,
        private readonly LoggerInterface $logger
    ) {
    }

    // todo вызывать метод только для определенного топика и/или топик + параметры из headers сообщения в kafka
    public function __invoke(TopicPricesMessage $message): void // todo реализовать работу с интерфейсом
    {
        /*$productAlias = $message->getKey();
        $priceValue = $message->getBody()['price'];
        $currencyValue = $message->getBody()['currency'];
        $price = new Price($priceValue, $currencyValue ?? 'USD');

        $product = $this->productFinder->__invoke($productAlias);
        $this->priceSetter->__invoke($product, $price);
        */
        $this->logger->notice('topic prices message processed');
    }
}
