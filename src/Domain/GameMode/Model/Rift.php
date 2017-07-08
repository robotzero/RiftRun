<?php

namespace App\Domain\GameMode\Model;

use App\Domain\GameMode\ValueObject\GameModeId;

/**
 * Class Rift
 * @package App\Domain\GameMode\Model\GameMode
 */
class Rift extends GameMode
{
    /**
     * @var int
     */
    private $torment;

    public function __construct(GameModeId $id, int $torment)
    {
        $this->torment = $torment;
        parent::__construct($id, 'rift');
    }

    /**
     * Get torment
     *
     * @return int
     */
    public function getTorment(): int
    {
        return $this->torment;
    }
}

