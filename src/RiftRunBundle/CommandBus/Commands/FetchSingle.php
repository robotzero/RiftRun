<?php

namespace RiftRunBundle\CommandBus\Commands;

class FetchSingle implements Fetch
{
    private $resourceId;

    private $repositoryName;

    public function __construct($resourceId, $repositoryName)
    {
        $this->resourceId = $resourceId;
        $this->repositoryName = $repositoryName;
    }

    public function getResourceId():string
    {
        return $this->resourceId;
    }

    public function getRepositoryName():string
    {
        return $this->repositoryName;
    }
}