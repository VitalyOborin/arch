<?php

declare(strict_types=1);

namespace Acme\Shared\Infrastructure\Bus\Transport;

use Acme\Product\Application\Transport\TopicPricesMessage;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

class TopicPricesSerializer implements SerializerInterface
{
    public function decode(array $encodedEnvelope): Envelope
    {
        return new Envelope(
            new TopicPricesMessage(
                $encodedEnvelope['key'],
                json_decode($encodedEnvelope['body'], true),
            )
        );
    }

    public function encode(Envelope $envelope): array
    {
        $message = $envelope->getMessage();

        return [
            'key' => $message->getKey(),
            'topic' => $message->getTopic(),
            'body' => json_encode($message->getBody(), JSON_UNESCAPED_UNICODE),
        ];
    }
}
