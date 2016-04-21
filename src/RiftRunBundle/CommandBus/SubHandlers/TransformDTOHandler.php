<?php

namespace RiftRunBundle\CommandBus\SubHandlers;

use RiftRunBundle\CommandBus\Handlers\CommandHandler;
use RiftRunBundle\DTO\DTO;
use RiftRunBundle\Model\Character;
use RiftRunBundle\Model\CharacterType;
use RiftRunBundle\Model\Grift;
use RiftRunBundle\Model\Post;
use RiftRunBundle\Model\SearchQuery;

final class TransformDTOHandler implements CommandHandler
{
    public function handle(DTO $dto)
    {
        $currentDate = new \DateTime('now');

        $searchQueryDTO = $dto->query;
        $gameTypeDTO = $searchQueryDTO->game;
        $characterDTO = $dto->player;
        $searchQuery = new SearchQuery($searchQueryDTO->minParagon, new Grift($gameTypeDTO->level), $currentDate);
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