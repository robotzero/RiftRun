<?php

namespace RiftRunBundle\CommandBus\Handlers;

use Hateoas\Configuration\Route;
use Hateoas\Representation\Factory\PagerfantaFactory;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use RiftRunBundle\CommandBus\Commands\Paginate;
use RiftRunBundle\Factories\Factory;

final class PaginatePostsCommandHandler
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
        $queryBuilder = $repository->match($paginate->getDefaultSpecification(), null);
        $pagerfanta = $this->pagerfantaFactory->getPagerfanta($queryBuilder);

        $pagerfanta->setMaxPerPage($paginate->getLimit());
        $pagerfanta->setCurrentPage($paginate->getPageNumber());

        $collection = $this->pagerfantaFactory->getPagerfantaLib()->createRepresentation($pagerfanta, $paginate->getRoute());

        return $collection;
    }
}