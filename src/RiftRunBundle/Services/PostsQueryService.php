<?php

namespace RiftRunBundle\Services;

use JMS\Serializer\SerializerInterface;
use League\Pipeline\PipelineBuilder;
use Hateoas\Configuration\Route;
use RiftRunBundle\CommandBus\Pipelines\PipelineManagerInterface;
use RiftRunBundle\ORM\Specification\AllPostsSpecification;
use RiftRunBundle\Services\Criteria\FetchCriteria;
use RiftRunBundle\Services\Pipelines\FetchPipeline;
use RiftRunBundle\Services\Pipelines\PaginatePipeline;
use RiftRunBundle\Services\Pipelines\SerializePipeline;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Response;

class PostsQueryService implements QueryService
{
    /** @var PipelineManagerInterface  */
    private $pipelineManager;

    /** @var RegistryInterface  */
    private $doctrine;

    /** @var SerializerInterface */
    private $serializer;

    public function __construct(PipelineManagerInterface $pipelineManager, RegistryInterface $doctrine, SerializerInterface $serializer)
    {
        $this->pipelineManager = $pipelineManager;
        $this->doctrine = $doctrine;
        $this->serializer = $serializer;
    }

    /**
     * @param int $page
     * @param int $limit
     * @param string $route
     * @return Response
     */
    public function query(int $page, int $limit, string $route):Response
    {
        $pipelineBuilder = (new PipelineBuilder)
            ->add(new FetchPipeline($this->doctrine))
            ->add(new PaginatePipeline($page, $limit, new Route($route, [], true)))
            ->add(new SerializePipeline($this->serializer));

        $pipeline = $pipelineBuilder->build();
        return $pipeline->process(new FetchCriteria(new AllPostsSpecification(), 'RiftRunners:Post'));
    }
}