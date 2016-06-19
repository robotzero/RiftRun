<?php

namespace RiftRunBundle\Services\Pipelines;

use Doctrine\ORM\QueryBuilder;
use RiftRunBundle\Services\Criteria\Criteria;
use Symfony\Bridge\Doctrine\RegistryInterface;

class FetchPipeline implements  ServicePipeline
{
    /** @var RegistryInterface */
    private $doctrine;

    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function __invoke(Criteria $criteria):QueryBuilder
    {
        $repositoryName = $criteria->getRepositoryName();
        $repository = $this->doctrine->getRepository($repositoryName);
        return $repository->match($criteria->getSpecification(), null);
    }
}