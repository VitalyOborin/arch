<?php

declare(strict_types=1);

namespace Acme\Shared\Port\Http;

use Acme\Shared\Domain\Bus\Command\CommandBus;
use Acme\Shared\Domain\Bus\Query\QueryBus;
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
}
