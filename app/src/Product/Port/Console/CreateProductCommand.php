<?php

declare(strict_types=1);

namespace Acme\Product\Port\Console;

use Acme\Product\Application\Command\Create\CreateCommand;
use Acme\Product\Domain\ValueObject\Price;
use Acme\Product\Service\ProductCreator;
use Acme\Shared\Domain\ValueObject\Uuid;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'product:create',
    description: 'Create new product',
)]
class CreateProductCommand extends Command
{
    public function __construct(private readonly MessageBusInterface $commandBus, string $name = null)
    {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('alias', InputArgument::REQUIRED, 'Product alias')
            ->addArgument('name', InputArgument::REQUIRED, 'Product name')
            ->addArgument('price', InputArgument::REQUIRED, 'Product price')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $id = Uuid::random()->value();
        $alias = (string) $input->getArgument('alias');
        $name = (string) $input->getArgument('name');
        $price = new Price((int) $input->getArgument('price'), 'USD');

        try {
            $this->commandBus->dispatch(new CreateCommand($id, $alias, $name, $price));
        } catch (\Exception $e) {
            $io->error($e->getMessage());

            return Command::FAILURE;
        }

        $io->success(sprintf('New product created with id = %s', $id));

        return Command::SUCCESS;
    }
}
