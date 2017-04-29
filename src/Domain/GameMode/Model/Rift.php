<?php

namespace App\Domain\GameMode\Model;

use App\Domain\GameMode\ValueObject\GameModeId;

/**
 * Class Rift
 * @package App\Domain\GameMode\Model\GameMode
 */
class Rift extends AbstractGameMode
{
    /**
     * @var int
     */
    private $torment;

    public function __construct(int $torment)
    {
        $this->torment = $torment;
        parent::__construct(new GameModeId(), 'rift');
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

