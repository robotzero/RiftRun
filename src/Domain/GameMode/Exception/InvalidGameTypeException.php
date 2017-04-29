<?php

namespace App\Domain\GameMode\Exception;

/**
 * Class InvalidGameTypeException
 * @package App\Domain\GameMode\Exception
 */
class InvalidGameTypeException extends \Exception
{
    /**
     * InvalidGameTypeException constructor.
     */
    public function __construct()
    {
        parent::__construct('game.exception.invalid_type', 9006);
    }
}