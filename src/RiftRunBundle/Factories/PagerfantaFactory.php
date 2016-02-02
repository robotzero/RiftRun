<?php

namespace RiftRunBundle\Factories;

use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

final class PagerfantaFactory implements Factory
{
    public function getPagerfanta(QueryBuilder $queryBuilder)
    {
        return new Pagerfanta(new DoctrineORMAdapter($queryBuilder));
    }

    public function getPagerfantaLib()
    {
        return new \Hateoas\Representation\Factory\PagerfantaFactory();
    }
}