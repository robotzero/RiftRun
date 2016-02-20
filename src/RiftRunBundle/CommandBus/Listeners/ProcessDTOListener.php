<?php

namespace RiftRunBundle\CommandBus\Listeners;

use RiftRunBundle\CommandBus\Commands\CreatePost;
use Symfony\Component\EventDispatcher\Event;

class ProcessDTOListener
{
    private $commandBus;

    public function __construct($commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function handle(Event $event)
    {
        $post = $event->getCreatedPost();
        $this->commandBus->handle(new CreatePost($post));
    }
}