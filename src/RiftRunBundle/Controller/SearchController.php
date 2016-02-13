<?php

namespace RiftRunBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use RiftRunBundle\CommandBus\Commands\FetchSingle;
use RiftRunBundle\CommandBus\Commands\PagerfantaPaginate;
use RiftRunBundle\CommandBus\Commands\SearchQuery;
use RiftRunBundle\ORM\Specification\SearchQuerySpecification;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Get;

class SearchController extends FOSRestController
{
    /**
     * @return array
     * @Get("/search/{id}")
     * @View()
     */
    public function searchAction(Request $request, $id)
    {
        $commandBus = $this->container->get('tactician.commandbus.default');
        $searchQuery = $commandBus->handle(new FetchSingle($id, 'SearchQuery'));

        return $commandBus->handle(
            new PagerfantaPaginate(
                new SearchQuerySpecification(),
                $searchQuery,
                1,
                25,
                'Post',
                'get_search'));
    }

    /**
     * @param Request $request
     */
    public function getSearchAction(Request $request)
    {
        // @TODO wierd.
    }


}