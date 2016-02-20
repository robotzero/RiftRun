<?php

namespace RiftRunBundle\CommandBus\Handlers;

use RiftRunBundle\CommandBus\Commands\Adapter;
use RiftRunBundle\CommandBus\Events\PostDTOEvent;
use RiftRunBundle\Model\Character;
use RiftRunBundle\Model\CharacterType;
use RiftRunBundle\Model\Grift;
use RiftRunBundle\Model\Post;
use RiftRunBundle\Model\SearchQuery;

final class TransformDTOModelCommandHandler implements CommandHandler
{
    private $eventDispatcher;

    public function __construct($eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handle(Adapter $adapter)
    {
        $currentDate = new \DateTime('now');
        $dto = $adapter->getDTO();

        $searchQueryDTO = $dto->query;
        $gameTypeDTO = $searchQueryDTO->game;
        $characterDTO = $dto->player;
        $searchQuery = new SearchQuery($searchQueryDTO->minParagon, new Grift($gameTypeDTO->level), $currentDate);
        $characterTypeDTOS = $searchQueryDTO->characterType;
        foreach ($characterTypeDTOS as $characterTypeDTO) {
            $characterType = new CharacterType($characterTypeDTO->type);
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

        $post = new Post($player, $searchQuery, $currentDate);

        $this->eventDispatcher->dispatch('process.dto', new PostDTOEvent($post));
    }
}