<?php

namespace App\Infrastructure\Common\Doctrine\ORM;

use Doctrine\ORM\EntityRepository as BaseEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 * Class EntityRepository
 * @package Infrastructure\Common\Doctrine\ORM
 */
class EntityRepository extends BaseEntityRepository
{
    /**
     * @param QueryBuilder $queryBuilder
     * @return Pagerfanta
     */
    protected function getPaginator(QueryBuilder $queryBuilder) : Pagerfanta
    {
        return new Pagerfanta(new DoctrineORMAdapter($queryBuilder, true, false));
    }

    /**
     * @param array $objects
     * @return Pagerfanta
     */
    protected function getArrayPaginator($objects) : Pagerfanta
    {
        return new Pagerfanta(new ArrayAdapter($objects));
    }
}