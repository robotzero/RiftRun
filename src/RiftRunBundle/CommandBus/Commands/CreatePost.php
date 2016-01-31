<?php

namespace RiftRunBundle\CommandBus\Commands;

use RiftRunBundle\Model\Post;

final class CreatePost implements Create
{
    public function getModel()
    {
        return new Post();
    }
}
