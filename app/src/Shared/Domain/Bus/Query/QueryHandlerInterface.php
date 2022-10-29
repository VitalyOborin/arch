<?php

declare(strict_types=1);

namespace Acme\Shared\Domain\Bus\Query;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

interface QueryHandlerInterface extends MessageHandlerInterface
{
}
