<?php

namespace RiftRunBundle\CommandBus\Events;

use RiftRunBundle\Model\Post;
use Symfony\Component\EventDispatcher\Event;

class PostDTOEvent extends Event
{
    private $createdPost;

    public function __construct(Post $post)
    {
        $this->createdPost = $post;
    }

    public function getCreatedPost():Post
    {
        return $this->createdPost;
    }
}