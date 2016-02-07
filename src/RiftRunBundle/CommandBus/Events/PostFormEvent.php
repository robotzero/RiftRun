<?php

namespace RiftRunBundle\CommandBus\Events;

use Symfony\Component\EventDispatcher\Event;

class PostFormEvent extends Event
{
    protected $processedObject;

    public function __construct($processedObject)
    {
        $this->processedObject = $processedObject;
    }

    public function getProcessedObject()
    {
        return $this->processedObject;
    }
}