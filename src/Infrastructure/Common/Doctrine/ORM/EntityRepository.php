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
     * @param array $keys
     * @param array $operators
     * @param array $values
     * @return Pagerfanta
     * @throws \App\Infrastructure\Common\Exception\Doctrine\ORM\CriteriaOperatorException
     */
    public function createOperatorPaginator(
        QueryBuilder $queryBuilder,
        array $keys = [],
        array $operators = [],
        array $values = []

    ): Pagerfanta
    {

        $this->applyCriteriaOperator($queryBuilder, $keys, $operators, $values);

        return $this->getPaginator($queryBuilder);
    }

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

    /**
     * @param QueryBuilder $queryBuilder
     * @param array $keys
     * @param array $operators
     * @param array $values
     * @return QueryBuilder
     * @throws \App\Infrastructure\Common\Exception\Doctrine\ORM\CriteriaOperatorException
     */
    protected function applyCriteriaOperator(
        QueryBuilder $queryBuilder,
        array $keys = [],
        array $operators = [],
        array $values = []
    ): QueryBuilder
    {
        foreach ($keys as $position => $value) {
            if (null === $value) {
                continue;
            }

            $name = $value;
            $parameter = ':' . str_replace('.', '_', $value) . $position;
            $operation = $operators[ $position ];
            $parameterValue = $values[ $position ];

            if ($this->startsWith($value, 'game.')) {
                $operator = new DiscriminatorCriteriaOperator();
                $discriminatorQB = $this->createQueryBuilder('gameMode');
                $queryBuilder = $operator->applyCriteria($queryBuilder, $values, $discriminatorQB, $operation, $name, $parameter, $parameterValue);
            } else {
                $operator = new StandardCriteriaOperator();
                $queryBuilder = $operator->applyCriteria($queryBuilder, $values, null, $operation, $name, $parameter, $parameterValue);
            }
        }

        return $queryBuilder;
    }

    /**
     * @param string $haystack
     * @param string $needle
     * @return bool
     */
    private function startsWith(string $haystack, string $needle): bool
    {
        return $needle === '' || strrpos($haystack, $needle, -strlen($haystack)) !== false;
    }
}