<?php

namespace RiftRunBundle\CommandBus\Handlers;

use RiftRunBundle\CommandBus\Commands\Adapter;

final class TransformDTOModelCommandHandler implements CommandHandler
{
    public function handle(Adapter $adapter)
    {
        $dto = $adapter->getDTO();

        $searchQuery = $dto->query;
        $gameType = $searchQuery->gameType;
        $player = $dto->player;

        return new Post(new SearchQuery($searchQuery->minParagon, new \DateTime('now')))
    }
}