<?php

namespace RiftRunBundle\CommandBus\Handlers;

use RiftRunBundle\CommandBus\Commands\SearchQuery;

final class SearchQueryCommandHandler implements CommandHandler
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function handle(SearchQuery $searchQuery)
    {
        $repository = $this->doctrine->getRepository('RiftRunners:' . $searchQuery->getRepositoryName());
        $queryBuilder = $repository->match($searchQuery->getSpecification(), $searchQuery->getSearchQueryObject());

        $results = $queryBuilder->getQuery()->execute();

        //print_r($searchQuery->getSearchQueryObject()->getId());
        //echo $searchQuery->getRepositoryName();
        return [];
    }
}