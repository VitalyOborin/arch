<?php

declare(strict_types=1);

namespace Acme\Tests\unit\Product\Domain\Product;

use Acme\Product\Domain\Product;
use Acme\Product\Domain\ValueObject\Price;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @covers \Acme\Product\Domain\Product
 */
final class ProductTest extends TestCase
{
    public function testCreate(): void
    {
        $expectedResult = [
            'test_alias',
            'Название товара',
            new Price(123, 'USD'),
        ];

        $product = new Product();
        $product->setAlias($expectedResult[0]);
        $product->setName($expectedResult[1]);
        $product->setPrice($expectedResult[2]);

        $this->assertSame(
            $expectedResult,
            [
                $product->getAlias(),
                $product->getName(),
                $product->getPrice(),
            ]
        );
    }
}
