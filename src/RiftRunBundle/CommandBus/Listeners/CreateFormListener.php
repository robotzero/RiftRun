<?php

namespace RiftRunBundle\CommandBus\Listeners;

use League\Event\EventInterface;
use League\Tactician\CommandBus;
use RiftRunBundle\CommandBus\Commands\DTOAdapter;
use Symfony\Component\EventDispatcher\Event;

class CreateFormListener
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
    public function handle(Event $event)
    {
        $processedObject = $event->getProcessedObject();

        $this->commandBus->handle(new DTOAdapter($processedObject));
    }
}