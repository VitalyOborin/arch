<?php

declare(strict_types=1);

namespace Acme\Product\Application\Command\Create;

use Acme\Product\Domain\Service\ProductCreator;
use Acme\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Exception;

class ProductCreateHandler implements CommandHandlerInterface
{
    public function __construct(private readonly ProductCreator $productCreator)
    {
    }

    public function __invoke(ProductCreateCommand $command): int
    {
        $alias = $command->getAlias();
        $name = $command->getName();
        $price = $command->getPrice();

        try {
            $this->productCreator->__invoke($alias, $name, $price);
        } catch (Exception $exception) {
            // todo
        }

        return self::COMMAND_SUCCESS;
    }
}
