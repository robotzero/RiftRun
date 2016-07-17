<?php

namespace RiftRunBundle\Services\Criteria;

use RiftRunBundle\ORM\Specification\Specification;

class FetchCriteria implements Criteria
{
    /** @var string  */
    private $repositoryName;

    /** @var Specification */
    private $specification;

    /** @var int */
    private $page;

    /** @var int */
    private $limit;

    public function __construct(Specification $specification, string $repositoryName, int $page, int $limit)
    {
        $this->specification = $specification;
        $this->repositoryName = $repositoryName;
        $this->page = $page;
        $this->limit = $limit;
    }

    public function getRepositoryName():string
    {
        return $this->repositoryName;
    }

    public function getSpecification():Specification
    {
        return $this->specification;
    }

    public function getPage():int
    {
        return $this->page;
    }

    public function getLimit():int
    {
        return $this->limit;
    }
}