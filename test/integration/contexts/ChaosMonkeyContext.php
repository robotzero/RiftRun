<?php

namespace Test\Integration\Context;

use Behat\Behat\Context\Context;
use DevHelperBundle\Command\Commands\LoadFixtures;
use Doctrine\Bundle\DoctrineBundle\Registry;
use League\Tactician\CommandBus;
use RiftRunBundle\Model\Post;

class ChaosMonkeyContext implements Context {

    private $doctrine;
    private $repositoryAlias = 'RiftRunners:';
    private $commandBus;

    /**
     * ChaosMonkeyContext constructor.
     * @param Registry $doctrine
     * @param CommandBus $commandBus
     */
    public function __construct(Registry $doctrine, CommandBus $commandBus)
    {
        $this->doctrine = $doctrine;
        $this->commandBus = $commandBus;
    }

    /**
     * @Given /^I have (\d+) posts missing (.*)$/
     * @param int $numberMissing
     * @param string $object
     */
    public function iHavePostsMissingObject(int $numberMissing , string $object)
    {
        $enityManager = $this->doctrine->getManager();
        $allEntities = $enityManager->getRepository($this->repositoryAlias . $object)->findAll();
        $slicedEntities = array_slice($allEntities, count($allEntities) - $numberMissing);
        foreach ($slicedEntities as $eachEntity) {
            $enityManager->remove($eachEntity);
        }
        $enityManager->flush();
    }

    /**
     * @Given /^I have (\d+) posts in the database older than (\d+) days$/
     */
    public function iHavePostsInTheDatabaseOlderThan($oldRecordAmount, $olderThanDays)
    {
        $fileLocations = [
            'test/Fixtures/DatabaseSeeder/Post/posts_29_old_x10.yml'
        ];

        $this->commandBus->handle(new LoadFixtures($fileLocations));
        $connection = $this->doctrine->getManager()->getConnection();

        $result = $connection->fetchAll("SELECT count() AS count FROM posts WHERE createdAt <= date('now', '-27 days') AND createdAt >= date('now', '-29 days')");

        assertTrue((int)$result[0]['count'] >= 5);
    }

    /**
     * @Given /^I have at least (\d+) posts older than a month$/
     */
    public function iHaveAtLeastPostsOlderThanAMonth($oldPostsNumber)
    {
        $fileLocations = [
            'test/Fixtures/DatabaseSeeder/Post/posts_old_x' . $oldPostsNumber . '.yml'
        ];

        $this->commandBus->handle(new LoadFixtures($fileLocations));

        $connection = $this->doctrine->getManager()->getConnection();

        $result = $connection->fetchAll("SELECT count() AS count FROM posts WHERE createdAt < date('now', '-1 month')");

        assertTrue((int)$result[0]['count'] === 10);
    }
}