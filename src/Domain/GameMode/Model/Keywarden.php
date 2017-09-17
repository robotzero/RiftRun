<?php

namespace App\Domain\GameMode\Model;

use App\Domain\GameMode\ValueObject\GameModeId;
use App\Domain\GameMode\ValueObject\GameType;

class Keywarden extends Rift
{
    /**
     * @param GameModeId $id
     * @param int $torment
     */
    public function __construct(GameModeId $id, int $torment)
    {
        parent::__construct($id, $torment);
        $this->gameMode = new GameType('keywardens');
    }
}