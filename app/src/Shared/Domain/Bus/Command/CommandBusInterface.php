<?php

declare(strict_types=1);

namespace Acme\Shared\Domain\Bus\Command;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): void;
}
