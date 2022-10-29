<?php

declare(strict_types=1);

namespace Acme\Product\Application\Command\SetPrice;

use Acme\Product\Domain\Exception\ProductNotFoundException;
use Acme\Product\Domain\Repository\ProductRepositoryInterface;
use Acme\Product\Domain\Service\ProductService;
use Acme\Product\Domain\ValueObject\Price;
use Acme\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(fromTransport: 'command')]
class SetPriceHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
        private readonly ProductService $productService
    ) {
    }

    public function __invoke(SetPriceCommand $command): int
    {
        $price = new Price($command->getPrice(), 'USD');
        if ($product = $this->productRepository->findOneByAlias($command->getAlias())) {
            $this->productService->setPrice($product, $price);
        } else {
            throw new ProductNotFoundException();
        }

        return self::COMMAND_SUCCESS;
    }
}
