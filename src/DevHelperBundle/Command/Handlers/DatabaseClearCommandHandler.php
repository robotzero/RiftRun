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

        // $q = $this->entityManager->createQuery('delete from RiftRunBundle\Model\Post m');
        // $numDeleted = $q->execute();
        // echo $numDeleted;


        $connection->exec('DELETE FROM characters');
        $connection->exec('DELETE FROM posts');
        $connection->exec('DELETE FROM grift');
        $connection->exec('DELETE FROM searchquery');
        $connection->exec('DELETE FROM gametype');
        $connection->exec('DELETE FROM characterclass');

        $connection->exec('DROP TABLE characters');
        $connection->exec('DROP TABLE posts');
        $connection->exec('DROP TABLE grift');
        $connection->exec('DROP TABLE searchquery');
        $connection->exec('DROP TABLE gametype');
        $connection->exec('DROP TABLE characterclass');

        //$connection->beginTransaction();
        // $connection->exec('VACUUM characters');
        // $connection->project('VACUUM characters');
        //$connection->commit();
        //$connection->commit();
    }
}
