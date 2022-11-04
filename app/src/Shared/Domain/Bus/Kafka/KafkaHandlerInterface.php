<?php

declare(strict_types=1);

namespace Acme\Shared\Domain\Bus\Kafka;

use Symfony\Component\Messenger\Handler\MessageSubscriberInterface; // todo remove infrastructure dependency

interface KafkaHandlerInterface extends MessageSubscriberInterface
{

}
