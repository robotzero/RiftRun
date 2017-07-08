<?php

namespace Test\Integration\Context;

use App\Domain\GameMode\ValueObject\GameModeId;
use App\Domain\Player\ValueObject\PlayerId;
use App\Domain\PlayerCharacter\ValueObject\PlayerCharacterId;
use App\Domain\Post\Model\Post;
use App\Domain\Post\ValueObject\PostId;
use App\Domain\SearchQuery\Model\SearchQuery;
use App\Domain\SearchQuery\ValueObject\SearchQueryId;
use Behat\Behat\Context\Context;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Pagerfanta\Pagerfanta;

class ChaosMonkeyContext implements Context {

    /** @var Registry  */
    private $doctrine;

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
     */
    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
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
     * @param int $daysOld
     * @param int $number
     * @param array $fixtures
     */
    public function changeCreatedDate(int $daysOld, int $number, array $fixtures): void
    {
        $entityManager = $this->doctrine->getManager();
        $createdAt = random_int($daysOld + 1, 100);
        $now = new \DateTime('now');
        $postEntities = [];
        foreach($fixtures as $index => $eachEntity) {
            if ($eachEntity instanceof Post) {
                $postEntities[] = $eachEntity;
//                $fixtures[] = $eachEntity;
            }
        }

        $slicedEntities = array_slice($postEntities, 0, $number);
        foreach($slicedEntities as $entity) {
            $newDateTime = $now->sub(new \DateInterval('P'.$createdAt.'D'));
            $entityManager->find(Post::class, new PostId($entity->getId()));
            $entity->setCreatedAt($newDateTime);
            $entityManager->persist($entity);
        }
        $entityManager->flush();
        echo count($fixtures);
    }
}