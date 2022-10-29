<?php

declare(strict_types=1);

namespace Acme\Product\Application\Command\AddProduct;

use Acme\Product\Domain\Exception\ProductAlreadyExistsException;
use Acme\Product\Domain\Repository\ProductRepositoryInterface;
use Acme\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(fromTransport: 'command')]
class AddProductHandler implements CommandHandlerInterface
{
    public function __construct(private readonly ProductRepositoryInterface $repository)
    {
    }

    public function __invoke(AddProductCommand $command): string
    {
        $product = $command->getProduct();
        if ($this->repository->findOneByAlias($product->getAlias()) === null) {
            $this->repository->add($product);
        } else {
            throw new ProductAlreadyExistsException();
        }

        return $product->getAlias();
    }
}
