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
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use VO\KafkaTransport\Messenger\Stamp\KafkaTopicStamp;

#[AsCommand(
    name: 'app:send-kafka',
    description: 'Send message to kafka topic',
)]
class SendMessageToKafka extends Command
{
    private MessageBusInterface $kafkaBus;

    public function __construct(MessageBusInterface $kafkaBus, string $name = null)
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
            $envelope = new Envelope(new TopicPricesMessage($alias, $message), [new KafkaTopicStamp('prices')]);
            $this->kafkaBus->dispatch($envelope);
        } catch (Exception $e) {
            $io->error($e->getMessage());

            return Command::FAILURE;
        }

        $io->success(sprintf('Message with alias = %s has been sent', $alias));

        return Command::SUCCESS;
    }
}
