<?php

namespace Infrastructure\Common\Pagination;
use Application\Request\Common\Pagination;
use Hateoas\Configuration\Route;
use Hateoas\Representation\Factory\PagerfantaFactory;
use Hateoas\Representation\PaginatedRepresentation;
use Pagerfanta\Pagerfanta;

/**
 * Class PaginationTrait
 * @package Infrastructure\Common\Pagination
 */
trait PaginationTrait
{
    /**
     * @param Pagerfanta $pager
     * @param string $route
     * @param array $params
     * @param int $limit
     * @param int $page
     *
     * @return PaginatedRepresentation
     * @throws \Pagerfanta\Exception\OutOfRangeCurrentPageException
     * @throws \Pagerfanta\Exception\NotIntegerCurrentPageException
     * @throws \Pagerfanta\Exception\LessThan1CurrentPageException
     * @throws \Pagerfanta\Exception\NotIntegerMaxPerPageException
     * @throws \Pagerfanta\Exception\LessThan1MaxPerPageException
     */
    public function getPagination(
        Pagerfanta $pager,
        string $route,
        array $params  = [],
        int $limit = Pagination::LIMIT,
        int $page = Pagination::PAGE) : PaginatedRepresentation
    {
        $pager
            ->setMaxPerPage($limit)
            ->setCurrentPage($page);

        //Merge pagination parameters
        $params = array_merge($params, [
            'limit' => $limit,
            'page' => $page
        ]);

        return (new PagerfantaFactory())->createRepresentation($pager, new Route($route, $params));
    }
}