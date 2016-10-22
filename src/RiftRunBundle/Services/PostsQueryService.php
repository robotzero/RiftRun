<?php

namespace RiftRunBundle\Services;

use Hateoas\Representation\Factory\PagerfantaFactory;
use JMS\Serializer\SerializerInterface;
use League\Pipeline\PipelineBuilder;
use Hateoas\Configuration\Route;
use RiftRunBundle\ORM\Specification\AllPostsSpecification;
use RiftRunBundle\Services\Pipelines\FetchPipeline;
use RiftRunBundle\Services\Pipelines\PaginatePipeline;
use RiftRunBundle\Services\Pipelines\SerializePipeline;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Response;

class PostsQueryService implements QueryService
{
    /** @var RegistryInterface  */
    private $doctrine;

    /** @var SerializerInterface */
    private $serializer;

    /** @var PagerfantaFactory */
    private $pagerfantaFactory;

    public function __construct(
        RegistryInterface $doctrine,
        SerializerInterface $serializer,
        PagerfantaFactory $pagerfantaFactory
    ) {
        $this->doctrine = $doctrine;
        $this->serializer = $serializer;
        $this->pagerfantaFactory = $pagerfantaFactory;
    }

    /**
     * @param int $page
     * @param int $limit
     * @param string $route
     * @return Response
     * @throws \InvalidArgumentException
     */
    public function query(int $page, int $limit, string $route):Response
    {
        $pipelineBuilder = (new PipelineBuilder)
            ->add(new FetchPipeline($this->doctrine, new AllPostsSpecification(), 'RiftRunners:Post'))
            ->add(new PaginatePipeline($page, $limit, new Route($route, [], true), $this->pagerfantaFactory))
            ->add(new SerializePipeline($this->serializer));

        $pipeline = $pipelineBuilder->build();
        return $pipeline->process(null);
    }
}