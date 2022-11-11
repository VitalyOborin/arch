<?php

declare(strict_types=1);

namespace Acme\Shared\Domain\Bus\Transport;

interface TransportBusInterface
{
    public function dispatch(TransportMessageInterface $message): void;
}
