<?php

declare(strict_types=1);

namespace Acme\Shared\Domain\Bus\Command;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

interface CommandHandlerInterface extends MessageHandlerInterface
{
    public const COMMAND_SUCCESS = 0;
    public const COMMAND_FAILED = 1;
}
