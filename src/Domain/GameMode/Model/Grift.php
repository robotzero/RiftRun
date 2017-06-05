<?php

namespace App\Domain\GameMode\Model;

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

    public function __construct(string $level)
    {
        $this->level = $level;
        parent::__construct('grift');
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
