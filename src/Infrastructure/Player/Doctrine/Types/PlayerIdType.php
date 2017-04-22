<?php

namespace App\Infrastructure\Player\Doctrine\Types;

use App\Domain\Player\ValueObject\PlayerId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Ramsey\Uuid\Doctrine\UuidBinaryType;

/**
 * Class PlayerIdType
 * @package App\Infrastructure\Player\Doctrine\Types
 */
class PlayerIdType extends UuidBinaryType
{
    const PLAYER_ID = 'playerId';

    /**
     * @param null|string $value
     * @param AbstractPlatform $platform
     * @return \App\Domain\Common\ValueObject\AggregateRootId|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : PlayerId::fromBytes($value);
    }

    /**
     * @param PlayerId $value
     * @param AbstractPlatform $platform
     * @return null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : $value->bytes();
    }

    public function getName(): string
    {
        return self::PLAYER_ID;
    }
}