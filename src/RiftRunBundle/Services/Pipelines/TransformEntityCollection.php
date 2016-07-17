<?php

namespace RiftRunBundle\Services\Pipelines;

use ArrayIterator;
use Pagerfanta\Pagerfanta;
use RiftRunBundle\DTO\CharacterDTO;
use RiftRunBundle\DTO\CharacterTypeDTO;
use RiftRunBundle\DTO\GriftDTO;
use RiftRunBundle\DTO\PostDTO;
use RiftRunBundle\DTO\RiftDTO;
use RiftRunBundle\DTO\SearchQueryDTO;
use RiftRunBundle\Model\Grift;
use RiftRunBundle\Model\Post;
use RiftRunBundle\Model\Rift;

/**
 * Class TransformEntityCollection
 * @package RiftRunBundle\Services\Pipelines
 */
class TransformEntityCollection
{
    /**
     * @param Pagerfanta $pagerfanta
     * @return array
     */
    public function transform(Pagerfanta $pagerfanta):array
    {
        /** @var ArrayIterator $results */
        $results = $pagerfanta->getCurrentPageResults();
        $r = array_map(function (Post $post) {
            $postCreatedAt = $post->getCreatedAt();
            $postId = $post->getId();
            $player = $post->getPlayer();
            $query = $post->getQuery();

            $queryId = $query->getId();
            $queryCreatedAt = $query->getCreatedAt();
            $queryCharacterTypes = $query->getCharacterType();
            $queryGame = $query->getGame();
            $queryMinParagon = $query->getMinParagon();

            $playerId = $player->getId();
            $playerCreatedAt = $player->getCreatedAt();
            $playerBattleTag = $player->getBattleTag();
            $playerGameType = $player->getGameType();
            $playerParagonPoints = $player->getParagonPoints();
            $playerRegion = $player->getRegion();
            $playerSeasonal = $player->getSeasonal();
            $playerType = $player->getType();

            $characters = [];
            foreach ($queryCharacterTypes->getValues() as $character) {
                $characterTypeDTO = new CharacterTypeDTO();
                $characterTypeDTO->type = $character->getType();
                $characters[] = $characterTypeDTO;
            }
            $searchQueryDTO = new SearchQueryDTO();
            $searchQueryDTO->characterType = $characters;
            $searchQueryDTO->createdAt = $queryCreatedAt;
            $searchQueryDTO->minParagon = $queryMinParagon;
            $gameTypeDTO = null;
            if ($queryGame instanceof Rift) {
                $gameTypeDTO = new RiftDTO();
                $gameTypeDTO->torment = $queryGame->getTorment();
            }

            if ($queryGame instanceof Grift) {
                $gameTypeDTO = new GriftDTO();
                $gameTypeDTO->level = $queryGame->getLevel();
            }
            $searchQueryDTO->game = $gameTypeDTO;
            $searchQueryDTO->createdAt = $queryCreatedAt;

            $playerDTO = new CharacterDTO();
            $playerDTO->createdAt = $playerCreatedAt;
            $playerDTO->type = $playerType;
            $playerDTO->battleTag = $playerBattleTag;
            $playerDTO->gameType = $playerGameType;
            $playerDTO->paragonPoints = $playerParagonPoints;
            $playerDTO->region = $playerRegion;
            $playerDTO->seasonal = $playerSeasonal;

            $postDTO = new PostDTO();
            $postDTO->createdAt = $postCreatedAt;
            $postDTO->player = $playerDTO;
            $postDTO->query = $searchQueryDTO;

            return $postDTO;
        }, $results->getArrayCopy());

        return $r;
    }
}