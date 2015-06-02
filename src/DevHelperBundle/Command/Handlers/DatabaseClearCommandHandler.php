<?php

namespace DevHelperBundle\Command\Handlers;

use DevHelperBundle\Command\Commands\ClearDatabaseInterface;
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
        $connection = $this->entityManager->getConnection();

        $connection->exec('DELETE FROM characters');
        //$connection->exec('VACUUM characters');
    }
}
