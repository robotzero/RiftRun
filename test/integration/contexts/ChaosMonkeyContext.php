<?php

namespace Test\Integration\Context;

use Behat\Behat\Context\Context;
use App\Command\Commands\LoadFixtures;
use Doctrine\Bundle\DoctrineBundle\Registry;
use League\Tactician\CommandBus;

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
     * @param string $clazz
     */
    public function iHavePostsMissingObject(int $numberMissing , string $clazz): void
    {
        //@TODO change to native query because removal could cascade.s
        $enityManager = $this->doctrine->getManager();
        $allEntities = $enityManager->getRepository($clazz)->findAll();
        $slicedEntities = array_slice($allEntities, count($allEntities) - $numberMissing);
        foreach ($slicedEntities as $eachEntity) {
            $enityManager->remove($eachEntity);
        }
        $enityManager->flush();
    }

    /**
     * @Given /^I have (\d+) posts in the database older than (\d+) days$/
     */
    public function iHavePostsInTheDatabaseOlderThan($oldRecordAmount, $olderThanDays): void
    {
        $fileLocations = [
            'test/Fixtures/DatabaseSeeder/Post/posts_' . $oldRecordAmount . '_old_x10.yml'
        ];

        $this->commandBus->handle(new LoadFixtures($fileLocations));
        $connection = $this->doctrine->getManager()->getConnection();

        $negativeOlderThanDays = ($olderThanDays * -1) . ' days';
        $numberOfDaysForDbQuery = sprintf("SELECT count() AS count FROM posts WHERE createdAt < date(%s, %s)", "'now'", "'$negativeOlderThanDays'");

        $result = $connection->fetchAll($numberOfDaysForDbQuery);
        assertTrue(((int)$result[0]['count']) === ((int)$oldRecordAmount));
    }
}