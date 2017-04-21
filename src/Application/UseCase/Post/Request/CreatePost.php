<?php

namespace App\Application\UseCase\Post\Request;

use App\Application\Common\Request\Create;

/**
 * Class CreatePost
 * @package App\Application\UseCase\Post\Request
 */
final class CreatePost implements Create
{
    /** @var  array */
    private $requestData;

    public function __construct(array $requestData)
    {
        $this->requestData = $requestData;
    }

    public function getRequestData():array
    {
        return $this->requestData;
    }
}
