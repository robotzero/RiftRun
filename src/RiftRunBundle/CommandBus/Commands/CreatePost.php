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

    public function __construct(string $formType, string $requestMethod)
    {
        $this->formType = $formType;
        $this->requestMethod = $requestMethod;
    }

    public function getFormType()
    {
        return $this->formType;
    }

    public function getRequestMethod()
    {
        return $this->requestMethod;
    }
}
