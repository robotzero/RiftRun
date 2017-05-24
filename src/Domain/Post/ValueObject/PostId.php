<?php

namespace App\Domain\Post\ValueObject;

use App\Domain\Common\ValueObject\AggregateRootId;

/**
 * Class PostId
 * @package Domain\Post\ValueObject
 */
class PostId extends AggregateRootId
{
    protected $uuid;
}