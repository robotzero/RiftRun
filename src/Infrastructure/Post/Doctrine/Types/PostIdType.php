<?php

namespace App\Infrastructure\Post\Doctrine\Types;

use App\Domain\Post\ValueObject\PostId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Ramsey\Uuid\Doctrine\UuidBinaryType;

class PostIdType extends UuidBinaryType
{
    const POST_ID = 'postId';

    /**
     * @param null|string $value
     * @param AbstractPlatform $platform
     * @return \App\Domain\Common\ValueObject\AggregateRootId|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : PostId::fromBytes($value);
    }

    /**
     * @param PostId $value
     * @param AbstractPlatform $platform
     * @return null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : $value->bytes();
    }

    public function getName(): string
    {
        return self::POST_ID;
    }
}