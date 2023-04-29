<?php

declare(strict_types=1);

namespace Acme\Shared\Infrastructure\Bus\Query;

use Acme\Shared\Domain\Bus\Query\Query;
use Acme\Shared\Domain\Bus\Query\QueryBus;
use Acme\Shared\Domain\Bus\Query\Response;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class InMemoryQueryBus implements QueryBus
{
    public function __construct(private readonly MessageBusInterface $queryBus)
    {
    }

    public function ask(Query $query): ?Response
    {
        try {
            /** @var HandledStamp $stamp */
            $stamp = $this->queryBus->dispatch($query)->last(HandledStamp::class);

            return $stamp->getResult();
        } catch (NoHandlerForMessageException) {
            throw new QueryNotRegisteredError($query);
        }
    }
}
