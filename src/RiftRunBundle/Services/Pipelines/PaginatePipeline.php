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

    public function __construct(int $pageNumber, int $limit, Route $route)
    {
        $this->pageNumber = $pageNumber;
        $this->limit = $limit;
        $this->route = $route;
    }

    public function __invoke(QueryBuilder $queryBuilder):PaginatedRepresentation
    {
        $pagerFanta = new Pagerfanta(new DoctrineORMAdapter($queryBuilder));
        $pagerFanta->setCurrentPage($this->pageNumber);
        $pagerFanta->setMaxPerPage($this->limit);
        $pagerFantaFactory = new PagerfantaFactory();

        return $pagerFantaFactory->createRepresentation($pagerFanta, $this->route);
    }
}