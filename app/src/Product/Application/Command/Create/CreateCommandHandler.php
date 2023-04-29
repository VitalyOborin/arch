<?php

declare(strict_types=1);

namespace Acme\Product\Application\Command\Create;

use Acme\Product\Service\ProductCreator;
use Acme\Shared\Domain\Bus\Command\CommandHandler;

class CreateCommandHandler implements CommandHandler
{
    public function __construct(private readonly ProductCreator $creator)
    {
    }

    public function __invoke(CreateCommand $command): void
    {
        $this->creator->__invoke(
            $command->id(),
            $command->alias(),
            $command->name(),
            $command->price()
        );
    }
}
