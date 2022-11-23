<?php

declare(strict_types=1);

namespace Acme\Product\Application\Transport;

use Acme\Shared\Domain\Bus\Transport\TransportHandlerInterface;
use Psr\Log\LoggerInterface;

class TopicProductsHandler implements TransportHandlerInterface
{
    public function __construct(
        // private readonly PriceSetter $priceSetter,
        // private readonly ProductFinder $productFinder,
        private readonly LoggerInterface $logger
    ) {
    }

    public function __invoke(TopicProductsMessage $message): void
    {
        $this->logger->notice('topic products message processed');
    }
}
