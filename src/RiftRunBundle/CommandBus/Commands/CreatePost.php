<?php

namespace RiftRunBundle\CommandBus\Commands;

use RiftRunBundle\CommandBus\Commands\Create;
use RiftRunBundle\Model\Post;

final class CreatePost implements Create
{
    public function getModel()
    {
        return new Post();
    }
}
