<?php

namespace RiftRunBundle\Factories;

use RiftRunBundle\Factories\Factory;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;

final class SingleTypeFactory extends ContainerAware implements Factory
{
    /** @var array */
    private $arrayObject;

    public function __construct()
    {
        $this->arrayObject =
            [
                'wizard' => 'RiftRunners:Character',
                'post' => 'RiftRunners:Post'
            ];
    }

    public function create($id, $type)
    {
        $repository = $this->container->get('doctrine')->getRepository($this->arrayObject[$type]);

        $entity = $repository->findOneBy(['id' => $id]);

        return new Response($this->container->get('serializer')->serialize($entity, 'json'));
    }
}
