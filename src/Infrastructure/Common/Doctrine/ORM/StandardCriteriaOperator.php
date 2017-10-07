<?php

namespace App\Infrastructure\Common\Doctrine\ORM;

use Doctrine\ORM\QueryBuilder;

/**
 * Class StandardCriteriaOperator
 * @package Infrastructure\Common\Doctrine\ORM
 */
class StandardCriteriaOperator implements CriteriaOperator
{
    /**
     * @param QueryBuilder $queryBuilder
     * @param array $values
     * @param QueryBuilder|null $discriminatorQB
     * @param string[] $criteria
     * @return QueryBuilder
     */
    public function applyCriteria(QueryBuilder $queryBuilder, array $values, QueryBuilder $discriminatorQB = null, string ...$criteria): QueryBuilder
    {
        [$operation, $name, $parameter, $parameterValue] = $criteria;

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
                    $queryBuilder->andWhere($queryBuilder->expr()->eq($name, $parameter));
                }
        }
        $queryBuilder->setParameter($parameter, $parameterValue);

        return $queryBuilder;
    }
}