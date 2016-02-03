<?php

namespace RiftRunBundle\CommandBus\Commands;

final class CreatePost implements Create
{
    /**
     * @var string
     */
    private $formType;

    /**
     * @var string
     */
    private $requestMethod;

    /**
     * @var array
     */
    private $requestData;

    public function __construct(string $formType, string $requestMethod, array $requestData)
    {
        $this->formType = $formType;
        $this->requestMethod = $requestMethod;
        $this->requestData = $requestData;
    }

    public function getFormType():string
    {
        return $this->formType;
    }

    public function getRequestMethod():string
    {
        return $this->requestMethod;
    }

    public function getRequestData():array
    {
        return $this->requestData;
    }
}
