<?php

declare(strict_types=1);

namespace Acme\Product\Port\Console\Command;

use Acme\Product\Application\Command\AddProduct\AddProductCommand;
use Acme\Product\Domain\Entity\Product;
use Acme\Product\Domain\ValueObject\Price;
use Acme\Shared\Domain\Bus\Command\CommandBusInterface;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:create-product',
    description: 'Create random product',
)]
class CreateProductCommand extends Command
{
    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus, string $name = null)
    {
        parent::__construct($name);
        $this->commandBus = $commandBus;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('alias', InputArgument::REQUIRED, 'Product alias to create')
            ->addOption('name', null, InputOption::VALUE_OPTIONAL, 'Product name');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $alias = $input->getArgument('alias');
        // $name = $input->getOption('name');

        $product = new Product($alias, 'Товар добавлен из консоли', new Price(100, 'USD'));

        try {
            $this->commandBus->dispatch(new AddProductCommand($product));
        } catch (Exception $e) {
            $io->error($e->getMessage());

            return Command::FAILURE;
        }

        $io->success(sprintf('Product with code = %s has been created', $alias));

        return Command::SUCCESS;
    }
}
