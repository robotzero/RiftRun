<?php

namespace App\Pipelines;

use Doctrine\Common\Collections\ArrayCollection;
use App\DTO\CharacterDTO;
use App\DTO\CharacterTypeDTO;
use App\DTO\GriftDTO;
use App\DTO\PostDTO;
use App\DTO\RiftDTO;
use App\DTO\SearchQueryDTO;
use App\Model\Grift;
use App\Model\Post;
use App\Model\Rift;

class TransformEntity
{
    /**
     * @param Post $post
     * @return PostDTO
     */
    public function transform(Post $post):PostDTO
    {
        $postDTO = new PostDTO();
        $searchQueryDTO = new SearchQueryDTO();
        $characterDTO = new CharacterDTO();
        $searchQueryDTO->id = $post->getQuery()->getId();
        $searchQueryDTO->minParagon = $post->getQuery()->getMinParagon();
        $characterDTOCollection = new ArrayCollection();
        $characterTypeDTOMaster = new CharacterTypeDTO();
        foreach ($post->getQuery()->getCharacterType() as $characterType) {
            $characterTypeDTO = clone $characterTypeDTOMaster;
            $characterTypeDTO->id = $characterType->getId();
            $characterTypeDTO->type = $characterType->getType();
            $characterDTOCollection->add($characterTypeDTO);
            $searchQueryDTO->characterType = $characterDTOCollection;
        }
        $searchQueryDTO->createdAt = $post->getQuery()->getCreatedAt();
        if ($post->getQuery()->getGame() instanceof Rift) {
            $riftDTO = new RiftDTO();
            $riftDTO->id = $post->getQuery()->getGame()->getId();
            $riftDTO->torment = $post->getQuery()->getGame()->getTorment();
            $riftDTO->type = 'Rift';
            $searchQueryDTO->game = $riftDTO;
        }

        if ($post->getQuery()->getGame() instanceof Grift) {
            $griftDTO = new GriftDTO();
            $griftDTO->id = $post->getQuery()->getGame()->getId();
            $griftDTO->level = $post->getQuery()->getGame()->getLevel();
            $griftDTO->type = 'Grift';
            $searchQueryDTO->game = $griftDTO;
        }

        $characterDTO->type = $post->getPlayer()->getType();
        $characterDTO->id = $post->getPlayer()->getId();
        $characterDTO->battleTag = $post->getPlayer()->getBattleTag();
        $characterDTO->createdAt = $post->getPlayer()->getCreatedAt();
        $characterDTO->gameType = $post->getPlayer()->getGameType();
        $characterDTO->paragonPoints = $post->getPlayer()->getParagonPoints();
        $characterDTO->region = $post->getPlayer()->getRegion();
        $characterDTO->seasonal = $post->getPlayer()->getSeasonal();
        $characterDTO->type = $post->getPlayer()->getType();
        $postDTO->query = $searchQueryDTO;
        $postDTO->player = $characterDTO;
        $postDTO->id = (string)$post->getId();
        $postDTO->createdAt = $post->getCreatedAt();

        return $postDTO;
    }
}