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
        $connection->exec('DELETE FROM posts');
        $connection->exec('DELETE FROM Grift');
        $connection->exec('DELETE FROM searchquery');
        $connection->exec('DELETE FROM gametype');
        $connection->exec('DELETE FROM characterclass');
        //$connection->exec('VACUUM characters');
    }
}
