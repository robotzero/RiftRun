<?php

namespace Test\Integration\Context;

use App\Domain\GameMode\ValueObject\GameModeId;
use App\Domain\Player\ValueObject\PlayerId;
use App\Domain\PlayerCharacter\ValueObject\PlayerCharacterId;
use App\Domain\Post\Model\Post;
use App\Domain\SearchQuery\Model\SearchQuery;
use App\Domain\SearchQuery\ValueObject\SearchQueryId;
use Behat\Behat\Context\Context;
use Doctrine\Bundle\DoctrineBundle\Registry;
use League\Tactician\CommandBus;

class ChaosMonkeyContext implements Context {

    /** @var Registry  */
    private $doctrine;

    /** @var CommandBus  */
    private $commandBus;

    /** @var array  */
    private $relationships = [
        'App\Domain\SearchQuery\Model\SearchQuery' => [
            'parent' => Post::class, 'method' => 'removeQuery', 'id' => SearchQueryId::class, 'field' => 'query'
        ],
        'App\Domain\Player\Model\Player' => [
            'parent' => Post::class, 'method' => 'removePlayer', 'id' => PlayerId::class, 'field' => 'player'
        ],
        'App\Domain\GameMode\Model\Grift' => [
            'parent' => SearchQuery::class, 'method' => 'removeGameMode', 'id' => GameModeId::class, 'field' => 'gameMode'
        ],
        'App\Domain\GameMode\Model\Rift' => [
            'parent' => SearchQuery::class, 'method' => 'removeGameMode', 'id' => GameModeId::class, 'field' => 'gameMode'
        ],
        'App\Domain\PlayerCharacter\Model\PlayerCharacter' => [
            'parent' => SearchQuery::class, 'method' => 'removePlayerCharacter', 'id' => PlayerCharacterId::class, 'field' => 'playerCharacters'
        ]
    ];

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
        $enityManager = $this->doctrine->getManager();
        $parentRepository = $enityManager->getRepository($this->relationships[$clazz]['parent']);
        $allEntities = $enityManager->getRepository($clazz)->findAll();
        $slicedEntities = array_slice($allEntities, count($allEntities) - $numberMissing);
        foreach ($slicedEntities as $eachEntity) {
            if ($clazz !== 'App\Domain\PlayerCharacter\Model\PlayerCharacter') {
                $parent = $parentRepository->findOneBy([$this->relationships[$clazz]['field'] => new $this->relationships[$clazz]['id']($eachEntity->getId())]);
                $method = $this->relationships[$clazz]['method'];
                $parent->$method();
            }
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
        
//        $this->commandBus->handle(new LoadFixtures($fileLocations));
//        $connection = $this->doctrine->getManager()->getConnection();
//
//        $negativeOlderThanDays = ($olderThanDays * -1) . ' days';
//        $numberOfDaysForDbQuery = sprintf("SELECT count() AS count FROM posts WHERE createdAt < date(%s, %s)", "'now'", "'$negativeOlderThanDays'");
//
//        $result = $connection->fetchAll($numberOfDaysForDbQuery);
//        assertTrue(((int)$result[0]['count']) === ((int)$oldRecordAmount));
    }
}