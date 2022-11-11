<?php

declare(strict_types=1);

namespace Acme\Product\Application\Command\Create;

use Acme\Product\Domain\Service\ProductCreator;
use Acme\Shared\Domain\Bus\Command\CommandHandlerInterface;

class ProductCreateCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly ProductCreator $productCreator)
    {
    }

    public function __invoke(ProductCreateCommand $command): int
    {
        $this->productCreator->__invoke(
            $command->getAlias(),
            $command->getName(),
            $command->getPrice()
        );

        return self::COMMAND_SUCCESS;
    }
}
