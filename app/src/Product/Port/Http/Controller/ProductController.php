<?php

declare(strict_types=1);

namespace Acme\Product\Port\Http\Controller;

use Acme\Product\Application\Command\Create\ProductCreateCommand;
use Acme\Product\Application\Query\Find\ProductFindQuery;
use Acme\Shared\Domain\Bus\Command\CommandBusInterface;
use Acme\Shared\Domain\Bus\Query\QueryBusInterface;
use Acme\Shared\Port\Http\Response\JsonErrorResponse;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class ProductController extends AbstractController
{
    private const RESULT_SUCCESS = '0';

    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly CommandBusInterface $commandBus,
    ) {
    }

    #[Route('/products/{alias}', methods: ['GET'])]
    public function getProductByCode(string $alias): Response
    {
        try {
            $product = $this->queryBus->query(new ProductFindQuery(alias: $alias))->getResult();
        } catch (Exception $e) {
            return new JsonErrorResponse($e);
        }

        return $this->json($product);
    }

    #[Route('/products/', methods: ['GET'])]
    public function addProduct(): Response
    {
        try {
            $this->commandBus->dispatch(
                new ProductCreateCommand(
                    alias: 'alias_uniq',
                    name: 'Some Name',
                    price: 100
                )
            );
        } catch (Exception $e) {
            return new JsonErrorResponse($e);
        }

        return $this->json(['result' => self::RESULT_SUCCESS]);
    }
}
