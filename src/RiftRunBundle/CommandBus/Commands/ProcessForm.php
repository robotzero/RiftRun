<?php

namespace RiftRunBundle\CommandBus\Commands;

use RiftRunBundle\Model\Post;
use Symfony\Component\HttpFoundation\Request;

interface ProcessForm
{
    public function getFormType():string;

    public function getRequestMethod():string;

    public function getRequestData():array;

    public function getRequest():Request;

    public function setPost(Post $post);
}