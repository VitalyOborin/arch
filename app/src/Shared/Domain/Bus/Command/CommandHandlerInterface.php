<?php

declare(strict_types=1);

namespace Acme\Shared\Domain\Bus\Command;

interface CommandHandlerInterface
{
    public const COMMAND_SUCCESS = 0;
    public const COMMAND_FAIL = 1;
}
