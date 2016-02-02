<?php

namespace RiftRunBundle\CommandBus\Commands;

use Hateoas\Configuration\Route;
use RiftRunBundle\ORM\Specification\AllPostsSpecification;
use RiftRunBundle\ORM\Specification\Specification;

final class PagerfantaPaginate implements Paginate
{
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

    public function __construct(int $page, int $limit, string $repositoryName, string $route)
    {
        $this->page = $page;
        $this->limit = $limit;
        $this->route = $route;
        $this->repositoryName = $repositoryName;
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

    public function getDefaultSpecification():Specification
    {
        return new AllPostsSpecification();
    }
}