<?php

declare(strict_types=1);

namespace Acme\Tests\unit\Product\Application\Command\ProductCreate;

use Acme\Product\Application\Command\Create\ProductCreateCommand;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @covers \Acme\Product\Application\Command\Create\ProductCreateCommand
 */
final class ProductCreateCommandTest extends TestCase
{
    public function testGetProduct(): void
    {
        $alias = 'test_alias';
        $name = 'Название товара';
        $price = 123;

        $command = new ProductCreateCommand($alias, $name, $price);

        $this->assertSame($alias, $command->getAlias());
        $this->assertSame($name, $command->getName());
        $this->assertSame($price, $command->getPrice());
    }
}
