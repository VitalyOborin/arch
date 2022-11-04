<?php

declare(strict_types=1);

namespace Acme\Shared\Infrastructure\Bus\Kafka;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\MessageDecodingFailedException;
use Symfony\Component\Messenger\Stamp\NonSendableStampInterface;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

use const JSON_UNESCAPED_UNICODE;

class KafkaJsonSerializer implements SerializerInterface
{
    public function decode(array $encodedEnvelope): Envelope
    {
        if (empty($encodedEnvelope['body'])) {
            throw new MessageDecodingFailedException('Encoded envelope should have at least a "body", or maybe you should implement your own serializer.');
        }

        $encodedEnvelope['body'] = json_decode($encodedEnvelope['body'], true);

        $message = new KafkaMessage(
            $encodedEnvelope['key'],
            $encodedEnvelope['topic'],
            $encodedEnvelope['body'],
            $encodedEnvelope['headers'],
            $encodedEnvelope['offset'],
            $encodedEnvelope['timestamp'],
        );

        return new Envelope($message);
    }

    public function encode(Envelope $envelope): array
    {
        $message = $envelope->withoutStampsOfType(NonSendableStampInterface::class)->getMessage();

        $body = json_encode($message->getBody(), JSON_UNESCAPED_UNICODE);
        $key = $message->getKey();

        return [
            'key' => $key,
            'body' => $body,
        ];
    }
}
