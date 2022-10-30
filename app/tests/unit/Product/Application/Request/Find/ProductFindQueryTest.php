<?php

declare(strict_types=1);

namespace Acme\Tests\unit\Product\Application\Request\Find;

use Acme\Product\Application\Request\Find\ProductFindQuery;
use Acme\Product\Domain\Entity\Product;
use Acme\Product\Domain\ValueObject\Price;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class ProductFindQueryTest extends TestCase
{
    public function testGetAlias(): void
    {
        $product = new Product();
        $product->setAlias('test_alias');
        $product->setName('Название товара');
        $product->setPrice(new Price(123456, 'USD'));

        $query = new ProductFindQuery($product->getAlias());

        $this->assertSame($product->getAlias(), $query->getAlias());
    }
}
