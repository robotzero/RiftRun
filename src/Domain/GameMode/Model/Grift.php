<?php

namespace App\Domain\GameMode\Model;

use App\Domain\GameMode\ValueObject\GameModeId;

/**
 * Class Grift
 * @package App\Domain\GameMode\Model\GameMode
 */
class Grift extends GameMode
{
    /**
     * @var string
     */
    private $level;

    public function __construct(GameModeId $id, string $level)
    {
        $this->level = $level;
        parent::__construct($id, 'grift');
    }

    /**
     * Get level
     *
     * @return string
     */
    public function getLevel(): string
    {
        return $this->level;
    }
}
