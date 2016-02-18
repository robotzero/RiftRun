<?php

namespace RiftRunBundle\CommandBus\Handlers;

use RiftRunBundle\CommandBus\Commands\Paginate;
use RiftRunBundle\Factories\Factory;

final class PaginatePostsCommandHandler implements CommandHandler
{
    private $doctrine;

    private $pagerfantaFactory;

    public function __construct($doctrine, Factory $pagerfantaFactory)
    {
        $this->doctrine = $doctrine;
        $this->pagerfantaFactory = $pagerfantaFactory;
    }

    public function handle(Paginate $paginate)
    {
        $repository = $this->doctrine->getRepository('RiftRunners:' . $paginate->getRepositoryName());
        $queryBuilder = $repository->match($paginate->getSpecification(), $paginate->getSearchQueryObject());
        $pagerfanta = $this->pagerfantaFactory->getPagerfanta($queryBuilder);

        $pagerfanta->setMaxPerPage($paginate->getLimit());
        $pagerfanta->setCurrentPage($paginate->getPageNumber());

        return $this->pagerfantaFactory->getPagerfantaLib()->createRepresentation($pagerfanta, $paginate->getRoute());
    }
}