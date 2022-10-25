<?php

declare(strict_types=1);

namespace Acme\Product\Application\Request\FindProduct;

use Acme\Product\Domain\Exception\ProductNotFoundException;
use Acme\Product\Domain\Repository\ProductRepositoryInterface;
use Acme\Shared\Domain\Bus\Query\QueryHandlerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(fromTransport: 'query')]
final class FindProductQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly ProductRepositoryInterface $repository)
    {
    }

    public function __invoke(FindProductQuery $query): FindProductResponse
    {
        $product = $this->repository->findOneByAlias($query->getAlias());

        if ($product === null) {
            throw new ProductNotFoundException();
        }

        return new FindProductResponse($product);
    }
}
