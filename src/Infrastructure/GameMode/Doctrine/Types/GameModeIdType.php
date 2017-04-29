<?php

namespace App\Infrastructure\GameMode\Doctrine\Types;

use App\Domain\GameMode\ValueObject\GameModeId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Ramsey\Uuid\Doctrine\UuidBinaryType;

/**
 * Class GameModeIdType
 * @package App\Infrastructure\GameType\Doctrine\Types
 */
class GameModeIdType extends UuidBinaryType
{
    const GAMEMODE_ID = 'gameModeId';

    /**
     * @param null|string $value
     * @param AbstractPlatform $platform
     * @return \App\Domain\Common\ValueObject\AggregateRootId|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : GameModeId::fromBytes($value);
    }

    /**
     * @param GameModeId $value
     * @param AbstractPlatform $platform
     * @return null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : $value->bytes();
    }

    public function getName(): string
    {
        return self::GAMEMODE_ID;
    }
}