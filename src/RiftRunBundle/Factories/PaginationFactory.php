<?php

namespace RiftRunBundle\Factories;

use Hateoas\Configuration\Route;
use Hateoas\Representation\Factory\PagerfantaFactory;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use RiftRunBundle\ORM\Specification\WizardsSpecification;

final class PaginationFactory implements Factory
{
    public function create($repository, $route, $limit, $page)
    {
        $specification = new WizardsSpecification();
        $queryBuilder = $repository->match($specification);
        $pagerfanta = new Pagerfanta(new DoctrineORMAdapter($queryBuilder));
        $pagerFantaFactory = new PagerfantaFactory();
        $pagerfanta->setMaxPerPage($limit);
        $pagerfanta->setCurrentPage($page);
        $route = new Route($route, [], true);

        return $pagerFantaFactory->createRepresentation($pagerfanta, $route);
    }
}
