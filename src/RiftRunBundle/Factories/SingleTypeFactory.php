<?php

namespace RiftRunBundle\Factories;

use RiftRunBundle\Factories\Factory;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;

final class SingleTypeFactory extends ContainerAware implements Factory
{
    public function __construct()
    {
        $this->arrayObject =
            [
                'wizard' => ['RiftRunners:Character'],
                'post' => ['RiftRunners:Post']
            ];
    }

    public function create($id, $type)
    {
        $repository = $this->container->get('doctrine')->getRepository($this->arrayObject[$type]);

        $wizard = $repository->findOneBy(['id' => $id, 'type' => $type]);

        return new Response($this->container->get('serializer')->serialize($wizard, 'json'));
    }
}
