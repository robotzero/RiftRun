<?php

namespace DevHelperBundle\Command\Handlers;

use DevHelperBundle\Command\Commands\ClearDatabaseInterface;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Purger\PurgerInterface;
use Doctrine\ORM\EntityManagerInterface;

final class DatabaseClearCommandHandler
{
    private $entityManager;

    private $ormPurger;

    public function __construct(
        EntityManagerInterface $entityManager,
        PurgerInterface $ormPurger
    ) {
        $this->entityManager = $entityManager;
        $this->ormPurger = $ormPurger;
    }

    public function handle(ClearDatabaseInterface $clearDatabase)
    {
        $executor = $clearDatabase->getORMExecutor(
            $this->entityManager,
            $this->ormPurger
        );

        $executor->purge();
        $this->entityManager->clear();
    }
}
