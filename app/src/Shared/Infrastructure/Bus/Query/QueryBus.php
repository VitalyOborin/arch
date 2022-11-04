<?php

declare(strict_types=1);

namespace Acme\Shared\Infrastructure\Bus\Query;

use Acme\Shared\Domain\Bus\Query\QueryBusInterface;
use Acme\Shared\Domain\Bus\Query\QueryInterface;
use Acme\Shared\Domain\Bus\Query\ResponseInterface;
use InvalidArgumentException;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class QueryBus implements QueryBusInterface
{
    public function __construct(private readonly MessageBusInterface $queryBus)
    {
    }

    public function query(QueryInterface $query): ResponseInterface
    {
        try {
            return $this->queryBus
                ->dispatch($query)
                ->last(HandledStamp::class)
                ->getResult();
        } catch (NoHandlerForMessageException $e) {
            throw new InvalidArgumentException(sprintf('The query has not a valid handler: %s', $query::class));
        }
    }
}
