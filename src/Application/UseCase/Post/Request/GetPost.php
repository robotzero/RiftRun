<?php

namespace App\Application\UseCase\Post\Request;

use App\Domain\Post\ValueObject\PostId;

/**
 * Class GetPost
 * @package App\Application\UseCase\Post\Request
 */
class GetPost
{
    /** @var PostId */
    private $uuid;

    public function __construct(string $uuid)
    {
        $this->uuid = new PostId($uuid);
    }

    /**
     * @return PostId
     */
    public function uuid(): PostId
    {
        return $this->uuid;
    }
}