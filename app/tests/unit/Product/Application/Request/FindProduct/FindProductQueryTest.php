<?php

declare(strict_types=1);

namespace Acme\Tests\unit\Product\Application\Request\FindProduct;

use Acme\Product\Application\Request\FindProduct\FindProductQuery;
use Acme\Product\Domain\Entity\Product;
use Acme\Product\Domain\ValueObject\Price;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class FindProductQueryTest extends TestCase
{
    public function testGetAlias(): void
    {
        $product = new Product();
        $product->setAlias('test_alias');
        $product->setName('Название товара');
        $product->setPrice(new Price(123456, 'USD'));

        $query = new FindProductQuery($product->getAlias());

        $this->assertSame($product->getAlias(), $query->getAlias());
    }
}
