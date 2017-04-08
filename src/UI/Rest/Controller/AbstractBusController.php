<?php

namespace App\UI\Rest\Controller;

use FOS\RestBundle\Controller\ControllerTrait;
use League\Tactician\CommandBus;

/**
 * Class AbstractBusController
 * @package UI\Rest\Controller
 */
abstract class AbstractBusController
{
    use ControllerTrait;

    /**
     * @var CommandBus
     */
    private $bus;

    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }

    /**
     * @param object $commandRequest
     * @return mixed
     */
    public function handle($commandRequest)
    {
        return $this->bus->handle($commandRequest);
    }
}