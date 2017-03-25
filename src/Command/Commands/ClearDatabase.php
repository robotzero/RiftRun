<?php

namespace App\Command\Commands;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Purger\PurgerInterface;
use Doctrine\ORM\EntityManagerInterface;

final class ClearDatabase implements ClearDatabaseInterface
{
    public function getORMExecutor(
        EntityManagerInterface $entityManager,
        PurgerInterface $ormPurger
    ):ORMExecutor {
        $ormPurger->setPurgeMode(ORMPurger::PURGE_MODE_TRUNCATE);
        return new ORMExecutor($entityManager, $ormPurger);
    }
}
