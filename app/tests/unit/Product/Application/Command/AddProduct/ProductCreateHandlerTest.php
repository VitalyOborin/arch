<?php

declare(strict_types=1);

namespace Acme\Tests\unit\Product\Application\Command\AddProduct;

use Acme\Product\Application\Command\Create\ProductCreateCommand;
use Acme\Product\Application\Command\Create\ProductCreateHandler;
use Acme\Product\Domain\Entity\Product;
use Acme\Product\Domain\Exception\ProductAlreadyExistsException;
use Acme\Product\Domain\Repository\ProductRepositoryInterface;
use Acme\Product\Domain\ValueObject\Price;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @covers \Acme\Product\Application\Command\Create\ProductCreateHandler
 */
final class ProductCreateHandlerTest extends TestCase
{
    public function testProductAdd(): void
    {
        $product = $this->createProduct();

        $productRepository = $this->createMock(ProductRepositoryInterface::class);

        $alias = (new ProductCreateHandler($productRepository))(new ProductCreateCommand($product));

        $this->assertSame($product->getAlias(), $alias);
    }

    public function testProductAddException(): void
    {
        $this->expectException(ProductAlreadyExistsException::class);
        $product = $this->createProduct();
        $productRepository = $this->createMock(ProductRepositoryInterface::class);

        $productRepository
            ->method('findOneByAlias')
            ->with($product->getAlias())
            ->willReturn($product);

        (new ProductCreateHandler($productRepository))(new ProductCreateCommand($product));
    }

    private function createProduct(): Product
    {
        $product = new Product();
        $product->setAlias('test_alias');
        $product->setName('Название товара');
        $product->setPrice(new Price(123, 'USD'));

        return $product;
    }
}
