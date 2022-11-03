<?php

declare(strict_types=1);

namespace Acme\Tests\unit\Product\Application\Command\ProductCreate;

use Acme\Product\Application\Command\Create\ProductCreateCommand;
use Acme\Product\Application\Command\Create\ProductCreateCommandHandler;
use Acme\Product\Domain\Exception\ProductAlreadyExistsException;
use Acme\Product\Domain\Service\ProductCreator;
use Acme\Shared\Domain\Bus\Command\CommandHandlerInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @covers \Acme\Product\Application\Command\Create\ProductCreateCommandHandler
 */
final class ProductCreateHandlerTest extends TestCase
{
    public const COMMAND_SUCCESS = CommandHandlerInterface::COMMAND_SUCCESS;
    public const COMMAND_FAIL = CommandHandlerInterface::COMMAND_FAIL;

    public function testProductAdd(): void
    {
        $alias = 'test_alias';
        $name = 'Название товара';
        $price = 123;

        $productCreator = $this->createMock(ProductCreator::class);
        $command = new ProductCreateCommand($alias, $name, $price);

        $result = (new ProductCreateCommandHandler($productCreator))($command);

        $this->assertEquals(self::COMMAND_SUCCESS, $result);
    }

    public function testProductAddException(): void
    {
        $this->expectException(ProductAlreadyExistsException::class);

        $alias = 'test_alias';
        $name = 'Название товара';
        $price = 123;

        $productCreator = $this->createMock(ProductCreator::class);
        $command = new ProductCreateCommand($alias, $name, $price);

        $productCreator->method('__invoke')->with($alias, $name, $price)->willThrowException(new ProductAlreadyExistsException());

        (new ProductCreateCommandHandler($productCreator))($command);
    }
}
