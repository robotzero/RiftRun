<?php

namespace App\Infrastructure\Common\Doctrine\ORM;

use App\Domain\GameMode\Model\Rift;
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
    const OPERATOR_GT = 'gt';
    const OPERATOR_LT = 'lt';
    const OPERATOR_EQ = 'eq';
    const OPERATOR_LTE = 'lte';
    const OPERATOR_GTE = 'gte';
    const OPERATOR_LIKE = 'like';
    const OPERATOR_BETWEEN = 'between';

    /**
     * @param QueryBuilder $queryBuilder
     * @param array $keys
     * @param array $operators
     * @param array $values
     *
     * @return Pagerfanta
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
     *
     * @return QueryBuilder
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
            $operation = $operators[$position];
            $parameterValue = $values[$position];


            switch ($operation) {

                case static::OPERATOR_GT:
                    $queryBuilder->andWhere($queryBuilder->expr()->gt($name, $parameter));
                    break;

                case static::OPERATOR_LT:
                    $queryBuilder->andWhere($queryBuilder->expr()->lt($name, $parameter));
                    break;

                case static::OPERATOR_GTE:
                    $queryBuilder->andWhere($queryBuilder->expr()->gte($name, $parameter));
                    break;

                case static::OPERATOR_LTE:
                    $queryBuilder->andWhere($queryBuilder->expr()->lte($name, $parameter));
                    break;

                case static::OPERATOR_LIKE:
                    $queryBuilder->andWhere($queryBuilder->expr()->like($name, $parameter));
                    $parameterValue = '%' . $parameterValue . '%';
                    break;

                case static::OPERATOR_BETWEEN:
                    $queryBuilder->andWhere($queryBuilder->expr()->between($name, $values[0], $values[1]));
                    break;

                case static::OPERATOR_EQ:

                default:
                    if (null === $parameterValue) {

                        $queryBuilder->andWhere($queryBuilder->expr()->isNull($parameter));

                    } elseif (is_array($parameterValue)) {

                        $queryBuilder->andWhere($queryBuilder->expr()->in($name, $parameter));

                    } elseif ('' !== $parameterValue) {
                        if ($name === 'game') {
                            $queryBuilder->andWhere($queryBuilder->expr()->orX($queryBuilder->expr()->isInstanceOf($name, $parameter), $queryBuilder->expr()->in('rift.id', $queryBuilder->select()->from(Rift::class, 'rift')->where('rift.torment=10'))));
                        } else {
                            $queryBuilder->andWhere($queryBuilder->expr()->eq($name, $parameter));
                        }
                    }
            }
            $queryBuilder->setParameter($parameter, $parameterValue);
        }

        return $queryBuilder;
    }
}