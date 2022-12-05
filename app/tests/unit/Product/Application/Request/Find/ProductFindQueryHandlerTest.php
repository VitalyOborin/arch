<?php

declare(strict_types=1);

namespace Acme\Tests\unit\Product\Application\Request\Find;

use Acme\Product\Application\Query\Find\ProductFindQuery;
use Acme\Product\Application\Query\Find\ProductFindQueryHandler;
use Acme\Product\Domain\Product;
use Acme\Product\Domain\Service\ProductFinder;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class ProductFindQueryHandlerTest extends TestCase
{
    public const ALIAS = 'alias1';

    public function testProductFindQueryHandler(): void
    {
        $product = new Product();
        $productFindQuery = $this->createMock(ProductFindQuery::class);
        $productFinder = $this->createMock(ProductFinder::class);

        $productFindQuery->method('getAlias')->willReturn(self::ALIAS);
        $productFinder->method('__invoke')->with($productFindQuery->getAlias())->willReturn($product);

        $newProduct = (new ProductFindQueryHandler($productFinder))($productFindQuery)->getResult();

        $this->assertEquals($product, $newProduct);
    }
}
