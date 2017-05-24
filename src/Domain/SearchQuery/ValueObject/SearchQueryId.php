<?php

namespace App\Domain\SearchQuery\ValueObject;

use App\Domain\Common\ValueObject\AggregateRootId;
use Ramsey\Uuid\Uuid;

/**
 * Class SearchQueryId
 * @package App\Domain\SearchQuery\ValueObject
 */
class SearchQueryId extends AggregateRootId
{
   /** @var  string */
    protected $uuid;
}