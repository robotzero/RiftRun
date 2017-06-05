<?php

namespace App\Domain\GameMode\Model;

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

    public function __construct(int $torment)
    {
        $this->torment = $torment;
        parent::__construct('rift');
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

