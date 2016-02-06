<?php

namespace RiftRunBundle\CommandBus\Commands;

use RiftRunBundle\Model\Post;

final class CreatePost implements Create
{
    /**
     * @var Post
     */
    private $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function getPost():Post
    {
        return $this->post;
    }
}
