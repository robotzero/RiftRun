<?php

namespace DevHelperBundle\Command\Handlers;

use DevHelperBundle\Command\Commands\ClearDatabaseInterface;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;

final class DatabaseClearCommandHandler
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(ClearDatabaseInterface $clearDatabase)
    {
        $purger = new ORMPurger($this->entityManager);
        $purger->setPurgeMode(2);
        $purger->purge();
        $this->entityManager->clear();
    }
}
