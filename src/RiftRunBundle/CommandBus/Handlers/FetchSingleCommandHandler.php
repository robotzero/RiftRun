<?php

namespace RiftRunBundle\CommandBus\Handlers;

use RiftRunBundle\CommandBus\Commands\Fetch;

final class FetchSingleCommandHandler implements CommandHandler
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function handle(Fetch $fetch)
    {
        $repository = $this->doctrine->getRepository('RiftRunners:' . $fetch->getRepositoryName());

        $singleEntity = $repository->findOneBy(['id' => $fetch->getResourceId()]);

        //@TODO Change to 400 bad request exception.
        if (is_null($singleEntity)) {
            throw new \Exception('Object not found!');
        }
        return $singleEntity;
    }
}