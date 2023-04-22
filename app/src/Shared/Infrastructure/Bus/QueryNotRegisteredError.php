<?php

declare(strict_types=1);

namespace Acme\Shared\Infrastructure\Bus;

use Acme\Shared\Domain\Bus\Query\Query;
use RuntimeException;

final class QueryNotRegisteredError extends RuntimeException
{
    public function __construct(Query $query)
    {
        $queryClass = $query::class;

        parent::__construct(sprintf('The query %s hasn\'t a query handler associated', $queryClass));
    }
}
