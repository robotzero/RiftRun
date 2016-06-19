<?php

namespace RiftRunBundle\Services\Pipelines;

use Doctrine\ORM\QueryBuilder;
use Hateoas\Representation\Factory\PagerfantaFactory;
use Hateoas\Representation\PaginatedRepresentation;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Hateoas\Configuration\Route;

class PaginatePipeline
{
    private $pageNumber;
    private $limit;
    private $route;
    private $factory;

    public function __construct(int $pageNumber, int $limit, Route $route, PagerfantaFactory $factory)
    {
        $this->pageNumber = $pageNumber;
        $this->limit = $limit;
        $this->route = $route;
        $this->factory = $factory;
    }

    public function __invoke(Pagerfanta $pagerfanta):PaginatedRepresentation
    {
        $pagerfanta->setCurrentPage($this->pageNumber);
        $pagerfanta->setMaxPerPage($this->limit);

        return $this->factory->createRepresentation($pagerfanta, $this->route);
    }
}