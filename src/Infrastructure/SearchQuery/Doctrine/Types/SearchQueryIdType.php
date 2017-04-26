<?php

namespace App\Infrastructure\SearchQuery\Doctrine\Types;

use App\Domain\SearchQuery\ValueObject\SearchQueryId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Ramsey\Uuid\Doctrine\UuidBinaryType;

/**
 * Class SearchQueryIdType
 * @package App\Infrastructure\Doctrine\Types
 */
class SearchQueryIdType extends UuidBinaryType
{
    const SEARCHQUERY_ID = 'searchQueryId';

    /**
     * @param null|string $value
     * @param AbstractPlatform $platform
     * @return \App\Domain\Common\ValueObject\AggregateRootId|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : SearchQueryId::fromBytes($value);
    }

    /**
     * @param SearchQueryId $value
     * @param AbstractPlatform $platform
     * @return null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : $value->bytes();
    }

    public function getName(): string
    {
        return self::SEARCHQUERY_ID;
    }
}