<?php

namespace DevHelperBundle\Command\Commands;

use Doctrine\Common\DataFixtures\Purger\PurgerInterface;
use Doctrine\ORM\EntityManagerInterface;

interface ClearDatabaseInterface
{
    public function getORMExecutor(EntityManagerInterface $entityManager, PurgerInterface $purger);
}
