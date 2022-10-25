<?php

declare(strict_types=1);

namespace Acme\Tests\unit\Product\Application\Command\AddProduct;

use Acme\Product\Application\Command\AddProduct\AddProductCommand;
use Acme\Product\Domain\Entity\Product;
use Acme\Product\Domain\ValueObject\Price;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @covers \Acme\Product\Application\Command\AddProduct\AddProductCommand
 */
final class AddProductCommandTest extends TestCase
{
    public function testGetProduct(): void
    {
        $product = new Product();
        $product->setAlias('test_alias');
        $product->setName('Название товара');
        $product->setPrice(new Price(123456, 'USD'));

        $command = new AddProductCommand($product);

        $this->assertSame($product, $command->getProduct());
    }
}
