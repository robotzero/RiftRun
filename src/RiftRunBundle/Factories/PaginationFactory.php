<?php

namespace RiftRunBundle\Factories;

use Hateoas\Configuration\Route;
use Hateoas\Representation\Factory\PagerfantaFactory;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use RiftRunBundle\ORM\Specification\AllPostsSpecification;
use RiftRunBundle\ORM\Specification\Specification;
use RiftRunBundle\ORM\Specification\WizardsSpecification;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

final class PaginationFactory extends ContainerAware implements Factory
{
    private $arrayObject;

    private $repository;

    private $request;

    private $postsSpecification;

    public function __construct(RequestStack $request, Specification $postsSpecification)
    {
        $this->request = $request;
        $this->postsSpecification = $postsSpecification;
        $this->arrayObject =
            [
                'post' => [$this->postsSpecification, 'Post']
            ];
    }
    public function create($type, $route)
    {
        $filters = $this->request->getCurrentRequest()->query->get('limit');

        $repositoryString = $this->arrayObject[$type][1];
        $this->repository = $this->container->get('doctrine')->getRepository('RiftRunners:'.$repositoryString);
        $queryBuilder = $this->repository->match($this->arrayObject[$type][0]);
        $pagerfanta = new Pagerfanta(new DoctrineORMAdapter($queryBuilder));
        $pagerFantaFactory = new PagerfantaFactory();
        $pagerfanta->setMaxPerPage($this->request->getCurrentRequest()->query->get('limit', 20));
        $pagerfanta->setCurrentPage($this->request->getCurrentRequest()->query->get('page', 1));
        $route = new Route($route, [], true);
        $collection = $pagerFantaFactory->createRepresentation($pagerfanta, $route);

        return new Response($this->container->get('serializer')->serialize($collection, 'json'));
    }
}
