<?php

namespace RiftRunBundle\Services\Pipelines;

use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use RiftRunBundle\ORM\Specification\Specification;
use Symfony\Bridge\Doctrine\RegistryInterface;

class FetchPipeline implements ServicePipeline
{
    /** @var RegistryInterface */
    private $doctrine;

    /** @var Specification */
    private $specification;

    /** @var string $repositoryName */
    private $repositoryName;

    /**
     * FetchPipeline constructor.
     * @param RegistryInterface $doctrine
     * @param Specification $specification
     * @param string $repositoryName
     */
    public function __construct(RegistryInterface $doctrine, Specification $specification, string $repositoryName)
    {
        $this->doctrine = $doctrine;
        $this->specification = $specification;
        $this->repositoryName = $repositoryName;
    }

    public function __invoke():Pagerfanta
    {
        $repository = $this->doctrine->getRepository($this->repositoryName);
        $queryBuilder = $repository->match($this->specification, null);
        return new Pagerfanta(new DoctrineORMAdapter($queryBuilder));
    }
}