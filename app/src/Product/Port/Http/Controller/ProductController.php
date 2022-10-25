<?php

declare(strict_types=1);

namespace Acme\Product\Port\Http\Controller;

use Acme\Product\Application\Command\AddProduct\AddProductCommand;
use Acme\Product\Application\Request\FindProduct\FindProductQuery;
use Acme\Product\Domain\Entity\Product;
use Acme\Product\Domain\ValueObject\Price;
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
            $product = $this->queryBus->query(new FindProductQuery(alias: $alias))->getResult();

            return $this->json($product);
        } catch (Exception $e) {
            return new JsonErrorResponse($e);
        }
    }

    #[Route('/products/', methods: ['GET'])]
    public function addProduct(): Response
    {
        try {
            $this->commandBus->dispatch(
                new AddProductCommand(
                    new Product('alias_uniq', 'Some Name', new Price(100, 'USD')) // todo get data from post values
                )
            );

            return $this->json(['result' => self::RESULT_SUCCESS]);
        } catch (Exception $e) {
            return new JsonErrorResponse($e);
        }
    }
}
