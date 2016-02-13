<?php

namespace RiftRunBundle\CommandBus\Handlers;

use JMS\Serializer\SerializerInterface;
use RiftRunBundle\CommandBus\Commands\Fetch;
use Symfony\Component\HttpFoundation\Response;

final class FetchSingleCommandHandler
{
    private $doctrine;

    private $serializer;

    public function __construct($doctrine, SerializerInterface $serializer)
    {
        $this->doctrine = $doctrine;
        $this->serializer = $serializer;
    }

    public function handle(Fetch $fetch)
    {
        $repository = $this->doctrine->getRepository('RiftRunners:' . $fetch->getRepositoryName());

        $singleEntity = $repository->findOneBy(['id' => $fetch->getResourceId()]);

        if (is_null($singleEntity)) {
            throw new \Exception('Search query not found!');
        }
        return $singleEntity;
    }
}