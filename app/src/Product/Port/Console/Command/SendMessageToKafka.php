<?php

declare(strict_types=1);

namespace Acme\Product\Port\Console\Command;


use Acme\Product\Application\Transport\Producer\Message\KafkaProducerMessage;
use Acme\Shared\Domain\Bus\Kafka\KafkaBusInterface;
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
    private KafkaBusInterface $kafkaBus;

    public function __construct(KafkaBusInterface $kafkaBus, string $name = null)
    {
        parent::__construct($name);
        $this->kafkaBus = $kafkaBus;
    }

    protected function configure(): void
    {
        $this->addArgument('message', InputArgument::REQUIRED, 'Message');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $message = $input->getArgument('message');

        try {
            $this->kafkaBus->dispatch(new KafkaProducerMessage($message));
        } catch (Exception $e) {
            $io->error($e->getMessage());

            return Command::FAILURE;
        }

        $io->success(sprintf('Product with code = %s has been updated', $message));

        return Command::SUCCESS;
    }
}
