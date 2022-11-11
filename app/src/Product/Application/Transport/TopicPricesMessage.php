<?php

declare(strict_types=1);

namespace Acme\Product\Application\Transport;

use Acme\Shared\Domain\Bus\Transport\TransportMessageInterface;

class TopicPricesMessage implements TransportMessageInterface
{
    public const TOPIC = 'prices';

    public function __construct(
        private readonly string $key,
        private readonly array $body
    ) {
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getBody(): array
    {
        return $this->body;
    }
}
