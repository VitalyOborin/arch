<?php

declare(strict_types=1);

namespace Acme\Product\Application\Command\SetPrice;

use Acme\Product\Domain\Exception\UnableToCreateProductException;
use Acme\Product\Domain\Service\PriceSetter;
use Acme\Product\Domain\Service\ProductFinder;
use Acme\Product\Domain\ValueObject\Price;
use Acme\Shared\Domain\Bus\Command\CommandHandlerInterface;

class SetPriceHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly PriceSetter $priceSetter,
        private readonly ProductFinder $productFinder,
    ) {
    }

    public function __invoke(SetPriceCommand $command): int
    {
        $price = new Price($command->getPrice(), 'USD');
        $product = $this->productFinder->__invoke($command->getAlias());

        if ($product) {
            $this->priceSetter->__invoke($product, $price);
        } else {
            throw new UnableToCreateProductException();
        }

        return self::COMMAND_SUCCESS;
    }
}
