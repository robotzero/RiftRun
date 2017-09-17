<?php

namespace App\Domain\GameMode\ValueObject;

use App\Domain\GameMode\Exception\InvalidGameTypeException;

/**
 * Class GameType
 * @package App\Domain\GameMode\ValueObject
 */
class GameType
{
    const
        RIFT = 'rift',
        GRIFT = 'grift',
        KEYWARDENS = 'keywardens',
        BOUNTIES = 'bounties',
        PROGRESSION = 'progression'
    ;

    /**
     * @var string
     */
    private $type;

    public function __construct(string $type)
    {
        $this->setType($type);
    }

    /**
     * @param string $type
     *
     * @throws InvalidGameTypeException
     */
    private function setType(string $type): void
    {
        if (!self::isValid($type)) {

            throw new InvalidGameTypeException();
        }

        $this->type = $type;
    }

    /**
     * @return array
     */
    public static function types(): array
    {
        return [
            self::RIFT,
            self::GRIFT,
            self::BOUNTIES,
            self::KEYWARDENS,
            self::PROGRESSION
        ];
    }

    /**
     * @param string $type
     * @return bool
     */
    public static function isValid(string $type): bool
    {
        return in_array($type, self::types(), true);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->type;
    }
}