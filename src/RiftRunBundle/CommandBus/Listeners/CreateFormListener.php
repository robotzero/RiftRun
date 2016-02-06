<?php

namespace RiftRunBundle\CommandBus\Listeners;

use League\Event\AbstractListener;
use League\Event\EventInterface;
use League\Tactician\CommandBus;
use RiftRunBundle\CommandBus\Commands\CreatePost;

class CreateFormListener extends AbstractListener
{
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * Handle an event.
     *
     * @param EventInterface $event
     *
     * @return void
     */
    public function handle(EventInterface $event)
    {
        $instanceName = 'RiftRunBundle\CommandBus\Commands\ProcessForm';

        if ($event->getCommand() instanceof $instanceName) {
            $post = $event->getCommand()->getPost();
            $this->commandBus->handle(new CreatePost($post));
        }

    }
}