<?php

namespace RiftRunBundle\CommandBus\Commands;

use Hateoas\Configuration\Route;
use RiftRunBundle\Model\SearchQuery as SearchQueryObject;
use RiftRunBundle\ORM\Specification\Specification;

final class PagerfantaPaginate implements Paginate
{
    /**
     * @var Specification
     */
    private $specification;

    /**
     * @var int
     */
    private $page;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var string
     */
    private $route;

    /**
     * @var string
     */
    private $repositoryName;

    private $searchQueryObject;

    public function __construct(Specification $specification, SearchQueryObject $searchQueryObject = null, int $page, int $limit, string $repositoryName, string $route)
    {
        $this->specification = $specification;
        $this->page = $page;
        $this->limit = $limit;
        $this->route = $route;
        $this->repositoryName = $repositoryName;
        $this->searchQueryObject = $searchQueryObject;
    }

    public function getLimit():int
    {
        return $this->limit;
    }

    public function getPageNumber():int
    {
        return $this->page;
    }

    public function getRoute():Route
    {
        return new Route($this->route, [], true);
    }

    public function getRepositoryName():string
    {
        return $this->repositoryName;
    }

    public function getSpecification():Specification
    {
        return $this->specification;
    }

    public function getSearchQueryObject()
    {
        return $this->searchQueryObject;
    }
}