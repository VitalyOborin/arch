<?php

declare(strict_types=1);

namespace Acme\Tests\unit\Product\Domain;

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
            'alias' => 'test_alias',
            'name' => 'Название товара',
            'price' => new Price(123, 'USD'),
        ];

        $product = new Product();
        $product->setAlias($expectedResult['alias']);
        $product->setName($expectedResult['name']);
        $product->setPrice($expectedResult['price']);

        $this->assertSame(
            $expectedResult,
            [
                'alias' => $product->getAlias(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
            ]
        );
    }

    public function testProductIdIsUuid(): void
    {
        $product = new Product();

        $this->assertMatchesRegularExpression(
            '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i',
            $product->getId()->getValue()
        );
    }
}
