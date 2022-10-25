<?php

declare(strict_types=1);

namespace Acme\Shared\Domain\Bus\Query;

use Acme\Shared\Domain\Aggregate\AggregateRoot;

interface ResponseInterface
{
    public function getResult(): AggregateRoot;
}
