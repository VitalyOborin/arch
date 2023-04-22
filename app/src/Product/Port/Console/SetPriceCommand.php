<?php

declare(strict_types=1);

namespace Acme\Product\Port\Console;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:set-price',
    description: 'Set new price for product',
)]
class SetPriceCommand extends Command
{
    public function __construct(string $name = null)
    {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('alias', InputArgument::REQUIRED, 'Product alias')
            ->addArgument('price', InputArgument::REQUIRED, 'Product price')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $alias = (string) $input->getArgument('alias');
        $price = (int) $input->getArgument('price');

        try {
            $io->comment('make some magic...'); // todo command to service PriceUpdater
        } catch (\Exception $e) {
            $io->error($e->getMessage());

            return Command::FAILURE;
        }

        $io->success(sprintf('Product with code = %s has been updated, new price = %d', $alias, $price));

        return Command::SUCCESS;
    }
}
