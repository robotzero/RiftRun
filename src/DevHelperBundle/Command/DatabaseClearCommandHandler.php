<?php

namespace DevHelperBundle\Command;

use DevHelperBundle\Command\ClearDatabase;
use Doctrine\ORM\EntityManagerInterface;

final class DatabaseClearCommandHandler
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(ClearDatabase $clearDatabase)
    {
        $connection = $this->entityManager->getConnection();

        $connection->exec('DELETE FROM characters');
        //$connection->exec('VACUUM characters');
    }
}
