<?php

namespace App\CommandBus\Commands;

use App\Model\SearchQuery as SearchQueryObject;
use App\ORM\Specification\Specification;

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