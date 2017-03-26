<?php

namespace App\Pipelines;

use Hateoas\Representation\Factory\PagerfantaFactory;
use Hateoas\Representation\PaginatedRepresentation;
use Pagerfanta\Pagerfanta;
use Hateoas\Configuration\Route;

class PaginatePipeline
{
    /**
     * @var int
     */
    private $pageNumber;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var Route
     */
    private $route;

    /**
     * @var PagerfantaFactory
     */
    private $factory;

    public function __construct(int $pageNumber, int $limit, Route $route, PagerfantaFactory $factory)
    {
        $this->pageNumber = $pageNumber;
        $this->limit = $limit;
        $this->route = $route;
        $this->factory = $factory;
    }

    /**
     * @param Pagerfanta $pagerfanta
     * @return PaginatedRepresentation
     * @throws \Pagerfanta\Exception\OutOfRangeCurrentPageException
     * @throws \Pagerfanta\Exception\NotIntegerMaxPerPageException
     * @throws \Pagerfanta\Exception\NotIntegerCurrentPageException
     * @throws \Pagerfanta\Exception\LessThan1MaxPerPageException
     * @throws \Pagerfanta\Exception\LessThan1CurrentPageException
     */
    public function __invoke(Pagerfanta $pagerfanta):PaginatedRepresentation
    {
        $pagerfanta->setCurrentPage($this->pageNumber);
        $pagerfanta->setMaxPerPage($this->limit);
        $transformer = new TransformEntityCollection();
        $collectionArray = $transformer->transform($pagerfanta);
        return $this->factory->createRepresentation($pagerfanta, $this->route, $collectionArray);
    }
}