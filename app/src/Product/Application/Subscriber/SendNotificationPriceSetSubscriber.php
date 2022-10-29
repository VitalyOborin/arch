<?php

declare(strict_types=1);

namespace Acme\Product\Application\Subscriber;

use Acme\Product\Domain\Event\PriceSetDomainEvent;
use Acme\Shared\Infrastructure\Bus\Event\DomainEventSubscriberAbstract;
use Psr\Log\LoggerInterface;

class SendNotificationPriceSetSubscriber extends DomainEventSubscriberAbstract
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            PriceSetDomainEvent::NAME => [
                ['onProductPriceSet', 10],
                ['onProductPriceSetLowPriority', -10],
            ],
        ];
    }

    public function onProductPriceSet(PriceSetDomainEvent $event): void
    {
        $product = $event->getProduct();
        $price = $event->getPrice();

        // send notification to log (example)
        $this->logger->info(sprintf(
            'price updated for product = %s new price = %d, occurred on %s',
            $product->getId(),
            $price->getValue(),
            $event->getOccurredOn()->format('Y-m-d H:i:s')
        ));
    }

    public function onProductPriceSetLowPriority(PriceSetDomainEvent $event): void
    {
        $product = $event->getProduct();
        $price = $event->getPrice();

        // send notification to log (example)
        $this->logger->info(sprintf(
            'LOW PRIORITY price updated for product = %s new price = %d',
            $product->getId(),
            $price->getValue()
        ));
    }
}
