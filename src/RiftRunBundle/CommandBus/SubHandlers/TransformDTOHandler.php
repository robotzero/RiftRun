<?php

namespace RiftRunBundle\CommandBus\SubHandlers;

use RiftRunBundle\CommandBus\Handlers\CommandHandler;
use RiftRunBundle\DTO\DTO;
use RiftRunBundle\DTO\GriftDTO;
use RiftRunBundle\DTO\RiftDTO;
use RiftRunBundle\Model\Character;
use RiftRunBundle\Model\CharacterType;
use RiftRunBundle\Model\Grift;
use RiftRunBundle\Model\Post;
use RiftRunBundle\Model\Rift;
use RiftRunBundle\Model\SearchQuery;

final class TransformDTOHandler implements CommandHandler
{
    public function handle(DTO $dto)
    {
        $currentDate = new \DateTime('now');

        $searchQueryDTO = $dto->query;
        $gameTypeDTO = $searchQueryDTO->game;
        $characterDTO = $dto->player;
        $gameType = null;

        if ($gameTypeDTO instanceof RiftDTO) {
            $gameType = new Rift($gameTypeDTO->torment);
        }

        if ($gameTypeDTO instanceof GriftDTO) {
            $gameType = new Grift($gameTypeDTO->level);
        }
        
        $searchQuery = new SearchQuery($searchQueryDTO->minParagon, $gameType, $currentDate);
        $characterTypeDTOS = $searchQueryDTO->characterType;
        foreach ($characterTypeDTOS as $characterTypeDTO) {
            $characterType = new CharacterType($searchQuery, $characterTypeDTO->type);
            $searchQuery->addCharacterType($characterType);
        }

        $player = new Character(
            $characterDTO->type,
            $characterDTO->paragonPoints,
            $characterDTO->battleTag,
            $characterDTO->region,
            $characterDTO->seasonal,
            $characterDTO->gameType,
            $currentDate
        );

        return new Post($player, $searchQuery, $currentDate);
    }
}