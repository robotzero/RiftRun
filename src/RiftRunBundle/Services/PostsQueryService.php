<?php

namespace RiftRunBundle\Services;

use League\Pipeline\PipelineBuilder;
use RiftRunBundle\CommandBus\Pipelines\PipelineManagerInterface;
use RiftRunBundle\ORM\Specification\AllPostsSpecification;
use RiftRunBundle\Services\Criteria\FetchCriteria;
use RiftRunBundle\Services\Pipelines\FetchPipeline;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PostsQueryService implements QueryService
{
    /** @var PipelineManagerInterface  */
    private $pipelineManager;

    /** @var RegistryInterface  */
    private $doctrine;
    public function __construct(PipelineManagerInterface $pipelineManager, RegistryInterface $doctrine)
    {
        $this->pipelineManager = $pipelineManager;
        $this->doctrine = $doctrine;
    }

    public function query()
    {
        $pipelineBuilder = (new PipelineBuilder)
            ->add(new FetchPipeline(new FetchCriteria(new AllPostsSpecification(), 'RiftRunBundle:Posts', $this->doctrine)));
        $pipeline = $pipelineBuilder->build();

    }
}