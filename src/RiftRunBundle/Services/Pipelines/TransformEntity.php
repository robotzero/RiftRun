<?php

namespace RiftRunBundle\Services\Pipelines;

use Doctrine\Common\Collections\ArrayCollection;
use RiftRunBundle\DTO\CharacterDTO;
use RiftRunBundle\DTO\CharacterTypeDTO;
use RiftRunBundle\DTO\GriftDTO;
use RiftRunBundle\DTO\PostDTO;
use RiftRunBundle\DTO\RiftDTO;
use RiftRunBundle\DTO\SearchQueryDTO;
use RiftRunBundle\Model\Grift;
use RiftRunBundle\Model\Post;
use RiftRunBundle\Model\Rift;

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
        foreach ($post->getQuery()->getCharacterType() as $characterType) {
            $collection = new ArrayCollection();
            $characterTypeDTO = new CharacterTypeDTO();
            $characterTypeDTO->id = $characterType->getId();
            $characterTypeDTO->type = $characterType->getType();
            $collection->add($characterTypeDTO);
            $searchQueryDTO->characterType = $collection;
        }
        $searchQueryDTO->createdAt = $post->getQuery()->getCreatedAt();
        if ($post->getQuery()->getGame() instanceof Rift) {
            $riftDTO = new RiftDTO();
            $riftDTO->id = $post->getQuery()->getGame()->getId();
            $riftDTO->torment = $post->getQuery()->getGame()->getTorment();
            $searchQueryDTO->game = $riftDTO;
        }
        if ($post->getQuery()->getGame() instanceof Grift) {
            $giftDTO = new GriftDTO();
            $giftDTO->id = $post->getQuery()->getGame()->getId();
            $giftDTO->level = $post->getQuery()->getGame()->getLevel();
            $searchQueryDTO->game = $giftDTO;
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