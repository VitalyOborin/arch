<?php

declare(strict_types=1);

namespace Acme\Shared\Domain\Bus\Query;

interface QueryBusInterface
{
    public function query(QueryInterface $query): ResponseInterface;
}
