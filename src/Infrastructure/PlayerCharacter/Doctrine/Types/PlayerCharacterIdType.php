<?php

namespace App\Infrastructure\PlayerCharacter\Doctrine\Types;

use App\Domain\PlayerCharacter\ValueObject\PlayerCharacterId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Ramsey\Uuid\Doctrine\UuidBinaryType;

/**
 * Class PlayerCharacterIdType
 * @package App\Infrastructure\PlayerCharacter\Doctrine\Types
 */
class PlayerCharacterIdType extends UuidBinaryType
{
    const PLAYERCHARACTER_ID = 'playerCharacterId';

    /**
     * @param null|string $value
     * @param AbstractPlatform $platform
     * @return \App\Domain\Common\ValueObject\AggregateRootId|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : PlayerCharacterId::fromBytes($value);
    }

    /**
     * @param PlayerCharacterId $value
     * @param AbstractPlatform $platform
     * @return null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : $value->bytes();
    }

    public function getName(): string
    {
        return self::PLAYERCHARACTER_ID;
    }
}