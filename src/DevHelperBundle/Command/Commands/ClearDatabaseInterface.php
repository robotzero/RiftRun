<?php

namespace DevHelperBundle\Command\Commands;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\PurgerInterface;
use Doctrine\ORM\EntityManagerInterface;

interface ClearDatabaseInterface
{
    /**
     * @param EntityManagerInterface $entityManager
     * @param PurgerInterface $ormPurger
     * @return ORMExecutor
     */
    public function getORMExecutor(
        EntityManagerInterface $entityManager,
        PurgerInterface $ormPurger
    ):ORMExecutor;
}
