<?php

namespace RiftRunBundle\Services\Pipelines;

use RiftRunBundle\Services\Criteria\Criteria;

class FetchPipeline implements  ServicePipeline
{
    /** @var  Criteria */
    private $criteria;

    public function __construct(Criteria $criteria)
    {
        $this->criteria = $criteria;
    }

    public function __invoke()
    {
        $repositoryName = $this->criteria->getRepositoryName();
        $doctrine = $this->criteria->getDoctrine();
        $repository = $doctrine->getRepository($repositoryName);
        return $repository->match($this->criteria->getSpecification(), null);
    }
}