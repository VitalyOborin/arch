<?php

declare(strict_types=1);

namespace Acme\Product\Port\Console\Command;

use Acme\Product\Application\Transport\TopicPricesMessage;
use Acme\Shared\Domain\Bus\Transport\TransportBusInterface;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:send-kafka',
    description: 'Send message to kafka topic',
)]
class SendMessageToKafka extends Command
{
    private TransportBusInterface $kafkaBus;

    public function __construct(TransportBusInterface $kafkaBus, string $name = null)
    {
        parent::__construct($name);
        $this->kafkaBus = $kafkaBus;
    }

    protected function configure(): void
    {
        $this->addArgument('alias', InputArgument::REQUIRED, 'Product alias');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $alias = $input->getArgument('alias');
        $message = ['price' => random_int(0, 1000)];

        try {
            $this->kafkaBus->dispatch(new TopicPricesMessage($alias, $message)); // todo сообщение должно отправлять только в определенный топик
        } catch (Exception $e) {
            $io->error($e->getMessage());

            return Command::FAILURE;
        }

        $io->success(sprintf('Product with code = %s has been updated', $alias));

        return Command::SUCCESS;
    }
}
