<?php

namespace RiftRunBundle\CommandBus\Commands;

use RiftRunBundle\Model\SearchQuery as SearchQueryObject;

final class SearchQuery
{
    private $searchQueryObject;

    private $repositoryName;

    public function __construct(SearchQueryObject $searchQueryObject, $repositoryName)
    {
        $this->searchQueryObject = $searchQueryObject;
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
}