<?php

declare(strict_types=1);

namespace Acme\Shared\Infrastructure\Bus\Transport;

use Acme\Product\Application\Transport\TopicPricesMessage;
use Exception;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

use const JSON_UNESCAPED_UNICODE;

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

    /**
     * @throws Exception
     */
    public function encode(Envelope $envelope): array
    {
        $message = $envelope->getMessage();

        if ($message instanceof TopicPricesMessage) {
            return [
                'key' => $message->getKey(),
                'topic' => $message->getTopic(),
                'body' => json_encode($message->getBody(), JSON_UNESCAPED_UNICODE),
            ];
        }

        throw new Exception('Unsupported message class');
    }
}
