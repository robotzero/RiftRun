<?php

namespace App\Domain\Player\ValueObject;

use App\Domain\Common\ValueObject\AggregateRootId;

/**
 * Class PlayerId
 * @package App\Domain\Player\ValueObject
 */
class PlayerId extends AggregateRootId
{
    /** @var  string */
    protected $uuid;
}