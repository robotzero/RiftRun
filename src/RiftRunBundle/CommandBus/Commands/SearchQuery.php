<?php

namespace RiftRunBundle\CommandBus\Commands;

use RiftRunBundle\Model\SearchQuery as SearchQueryObject;
use RiftRunBundle\ORM\Specification\Specification;

final class SearchQuery
{
    private $searchQueryObject;

    private $repositoryName;

    private $specification;

    public function __construct(SearchQueryObject $searchQueryObject, Specification $specification, $repositoryName)
    {
        $this->searchQueryObject = $searchQueryObject;
        $this->specification = $specification;
        $this->repositoryName = $repositoryName;
    }

    public function getSearchQueryObject():SearchQueryObject
    {
        return $this->searchQueryObject;
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