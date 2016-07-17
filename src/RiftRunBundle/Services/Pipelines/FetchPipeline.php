<?php

namespace RiftRunBundle\Services\Pipelines;

use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use RiftRunBundle\Services\Criteria\Criteria;
use Symfony\Bridge\Doctrine\RegistryInterface;

class FetchPipeline implements  ServicePipeline
{
    /** @var RegistryInterface */
    private $doctrine;

    /**
     * FetchPipeline constructor.
     * @param RegistryInterface $doctrine
     */
    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function __invoke(Criteria $criteria):Pagerfanta
    {
        $repositoryName = $criteria->getRepositoryName();
        $repository = $this->doctrine->getRepository($repositoryName);
        $queryBuilder = $repository->match($criteria->getSpecification(), null);
        return new Pagerfanta(new DoctrineORMAdapter($queryBuilder));
    }
}