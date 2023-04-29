<?php

declare(strict_types=1);

namespace Acme\Shared\Port\Http;

use Acme\Shared\Domain\Bus\Command\Command;
use Acme\Shared\Domain\Bus\Command\CommandBus;
use Acme\Shared\Domain\Bus\Query\Query;
use Acme\Shared\Domain\Bus\Query\QueryBus;
use Acme\Shared\Domain\Bus\Query\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

abstract class ApiControllerAbstract
{
    public function __construct(
        private readonly QueryBus $queryBus,
        private readonly CommandBus $commandBus,
    ) {
    }

    abstract public function __invoke(Request $request): JsonResponse;

    protected function ask(Query $query): ?Response
    {
        return $this->queryBus->ask($query);
    }

    protected function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }
}
