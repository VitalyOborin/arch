<?php

declare(strict_types=1);

namespace Acme\Shared\Domain\Bus\Query;

use InvalidArgumentException;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class QueryBus implements QueryBusInterface
{
    public function __construct(private readonly MessageBusInterface $messageBus)
    {
    }

    public function query(QueryInterface $query): ResponseInterface
    {
        try {
            $stamp = $this->messageBus->dispatch($query)->last(HandledStamp::class);

            return $stamp->getResult();
        } catch (NoHandlerForMessageException $e) {
            throw new InvalidArgumentException(sprintf('The query has not a valid handler: %s', $query::class));
        }
    }
}
