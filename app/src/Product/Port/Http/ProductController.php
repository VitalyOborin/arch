<?php

declare(strict_types=1);

namespace Acme\Product\Port\Http;

use Acme\Product\Application\Query\FindProductByAlias\FindProductByAliasQuery;
use Acme\Product\Application\Query\ProductResponse;
use Acme\Shared\Domain\Bus\Query\QueryBus;
use Acme\Shared\Port\Http\ApiControllerAbstract;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class ProductController extends ApiControllerAbstract
{
    public function __construct(
        private readonly QueryBus $queryBus
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $alias = $request->attributes->get('alias');

        /** @var ProductResponse $response */
        $response = $this->queryBus->ask(new FindProductByAliasQuery($alias));

        return new JsonResponse(
            [
                'product' => [
                    'id' => $response->id(),
                    'alias' => $response->alias(),
                    'name' => $response->name(),
                    'price' => $response->price(),
                ]
            ]
        );
    }
}
