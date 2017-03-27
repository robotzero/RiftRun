<?php

namespace App\CommandBus\Pipelines;

use App\DTO\DTO;
use App\DTO\GriftDTO;
use App\DTO\RiftDTO;
use App\DTO\SearchQueryDTO;
use App\Model\Character;
use App\Model\CharacterType;
use App\Model\Grift;
use App\Model\Post;
use App\Model\Rift;
use App\Model\SearchQuery;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class TransformDTOPipe
{
    public function __invoke(DTO $dto)
    {
        $currentDate = new \DateTime('now');

        /** @var SearchQueryDTO $searchQueryDTO */
        $searchQueryDTO = $dto->query;
        $gameTypeDTO = $searchQueryDTO->game;
        $characterDTO = $dto->player;
        $gameType = null;

        try {
            if ($gameTypeDTO instanceof RiftDTO) {
                $gameType = new Rift($gameTypeDTO->torment);
            }

            if ($gameTypeDTO instanceof GriftDTO) {
                $gameType = new Grift($gameTypeDTO->level);
            }

            $searchQuery = new SearchQuery($searchQueryDTO->minParagon, $gameType, $currentDate);
            /*  @var $characterTypeDTOS \Doctrine\Common\Collections\Collection */
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
        } catch (\Throwable $e) {
            if (strpos($e, 'Argument') !== false && strpos($e, 'passed') !== false) {
                throw new BadRequestHttpException('Missing');
            }
            throw $e;
        }

        return new Post($player, $searchQuery, $currentDate);
    }
}