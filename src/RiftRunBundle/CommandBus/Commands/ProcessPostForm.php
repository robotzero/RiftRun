<?php

namespace RiftRunBundle\CommandBus\Commands;

use RiftRunBundle\Model\Post;
use Symfony\Component\HttpFoundation\Request;

class ProcessPostForm implements ProcessForm
{
    private $request;

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

    public function __construct(Request $request, string $formType, string $requestMethod, array $requestData)
    {
        $this->request = $request;
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

    public function getRequest():Request
    {
        return $this->request;
    }
}