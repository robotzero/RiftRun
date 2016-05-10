<?php

namespace RiftRunBundle\CommandBus\Commands;

interface Fetch
{
    public function getResourceId():string;

    public function getRepositoryName():string;
}