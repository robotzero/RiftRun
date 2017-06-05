<?php

namespace App\Domain\Post\Exception;

use App\Domain\Common\NotFoundException;

/**
 * Class PostNotFoundException
 * @package App\Application\Domain\Post\Exception
 */
class PostNotFoundException extends NotFoundException
{
    /**
     * PostNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('post.exception.not_found', 8004);
    }
}