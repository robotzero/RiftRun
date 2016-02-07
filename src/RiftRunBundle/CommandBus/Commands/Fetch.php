<?php

namespace RiftRunBundle\CommandBus\Commands;

interface Fetch
{
    public function getResourceId():int;

    public function getRepositoryName():string;
}