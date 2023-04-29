<?php

declare(strict_types=1);

namespace Acme\Shared\Infrastructure\Mongo;

use Doctrine\ODM\MongoDB\DocumentManager;

abstract class MongoRepository
{
    public function __construct(protected readonly DocumentManager $dm)
    {
    }

    protected function documentManager(): DocumentManager
    {
        return $this->dm;
    }
}
