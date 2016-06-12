<?php

namespace RiftRunBundle\Services\Criteria;

use RiftRunBundle\ORM\Specification\Specification;
use Symfony\Bridge\Doctrine\RegistryInterface;

class FetchCriteria implements Criteria
{
    /** @var string  */
    private $repositoryName;

    /** @var Specification */
    private $specification;

    /** @var RegistryInterface */
    private $doctrine;

    public function __construct(Specification $specification, string $repositoryName, $doctrine)
    {
        $this->specification = $specification;
        $this->repositoryName = $repositoryName;
        $this->doctrine = $doctrine;
    }

    public function getRepositoryName():string
    {
        return $this->repositoryName;
    }

    public function getSpecification():Specification
    {
        return $this->specification;
    }

    public function getDoctrine()
    {
        return $this->doctrine;
    }

}