<?php

namespace RiftRunBundle\CommandBus\Commands;

use Doctrine\Bundle\DoctrineBundle\Registry;
use RiftRunBundle\ORM\Specification\AllPostsSpecification;
use RiftRunBundle\ORM\Specification\Specification;
use Symfony\Component\HttpFoundation\RequestStack;

class PagerfantaPaginate implements Paginate
{
    private $requestStack;

    private $doctrine;

    public function __construct(RequestStack $requestStack, Registry $doctrine)
    {
        $this->requestStack = $requestStack;
        $this->doctrine = $doctrine;
    }

    public function getLimit():int
    {
        return $this->requestStack->getCurrentRequest()->get('limit', 20);
    }

    public function getPageNumber():int
    {
        return $this->requestStack->getCurrentRequest()->get('page', 1);
    }

    public function getRepository(string $repositoryName)
    {
        return $this->doctrine->getRepository($repositoryName);
    }

    public function getDefaultSpecification():Specification
    {
        return new AllPostsSpecification();
    }
}