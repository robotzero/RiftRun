<?php

namespace RiftRunBundle\Services\Criteria;

use RiftRunBundle\ORM\Specification\Specification;

class FetchCriteria implements Criteria
{
    /** @var string  */
    private $repositoryName;

    /** @var Specification */
    private $specification;

    public function __construct(Specification $specification, string $repositoryName)
    {
        $this->specification = $specification;
        $this->repositoryName = $repositoryName;
    }

    public function getRepositoryName():string
    {
        return $this->repositoryName;
    }

    public function getSpecification():Specification
    {
        return $this->specification;
    }
}