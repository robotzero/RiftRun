<?php

namespace App\Infrastructure\Common\Doctrine\ORM;

use App\Infrastructure\Common\Exception\Doctrine\ORM\CriteriaOperatorException;
use Doctrine\ORM\Query\Expr\Andx;
use Doctrine\ORM\QueryBuilder;

class DiscriminatorCriteriaOperator implements CriteriaOperator
{

    /**
     * @param QueryBuilder $queryBuilder
     * @param array $values
     * @param QueryBuilder|null $discriminatorQB
     * @param string[] $criteria
     * @throws CriteriaOperatorException
     */
    public function applyCriteria(QueryBuilder $queryBuilder, array $values, QueryBuilder $discriminatorQB = null, string ...$criteria): void
    {
        [$operation, $name, $parameter, $parameterValue] = $criteria;
        [$parameterValueName, $parameterValueClass, $parameterValueLevel] = explode('.', $name);
        $alias = $parameterValueName . $parameterValueClass;
        switch ($operation) {

            case static::OPERATOR_GT:
                $dql = $discriminatorQB->select($alias . 'gm.id')
                                       ->from(static::CLASS_MAP[$parameterValueClass], $alias . 'gm')
                                       ->andWhere($queryBuilder->expr()->gt($alias . 'gm.' . $parameterValueLevel, $parameterValue))
                                       ->getDQL();
                break;

            case static::OPERATOR_LT:
                $dql = $discriminatorQB->select($alias . 'gm.id')
                                       ->from(static::CLASS_MAP[$parameterValueClass], $alias . 'gm')
                                       ->andWhere($queryBuilder->expr()->lt($alias . 'gm.' . $parameterValueLevel, $parameterValue))
                                       ->getDQL();
                break;

            case static::OPERATOR_GTE:
                $dql = $discriminatorQB->select($alias . 'gm.id')
                                       ->from(static::CLASS_MAP[$parameterValueClass], $alias . 'gm')
                                       ->andWhere($queryBuilder->expr()->gte($alias . 'gm.' . $parameterValueLevel, $parameterValue))
                                       ->getDQL();
                break;

            case static::OPERATOR_LTE:
                $dql = $discriminatorQB->select($alias . 'gm.id')
                                       ->from(static::CLASS_MAP[$parameterValueClass], $alias . 'gm')
                                       ->andWhere($queryBuilder->expr()->lte($alias . 'gm.' . $parameterValueLevel, $parameterValue))
                                       ->getDQL();
                break;

            case static::OPERATOR_LIKE:
                throw new CriteriaOperatorException(static::OPERATOR_LIKE . ' is not supported on discriminator column.');

            case static::OPERATOR_BETWEEN:
                $dql = $discriminatorQB->select('gm.id')
                                       ->from(static::CLASS_MAP[$parameterValueClass], 'gm')
//                                       ->andWhere($queryBuilder->expr()->between('gm.' . $parameterValueLevel, $parameterValue))
                                       ->getDQL();
//                $queryBuilder->andWhere($queryBuilder->expr()->between($name, $values[0], $values[1]));
                break;

            case static::OPERATOR_EQ:

            default:
                if (null === $parameterValue) {
                    throw new CriteriaOperatorException('null value is not supported on discriminator column.');
                }

                if (is_array($parameterValue)) {
                    $dql = $discriminatorQB->select($alias . 'gm.id')
                                           ->from(static::CLASS_MAP[$parameterValueClass], $alias . 'gm')
                                           ->andWhere($queryBuilder->expr()->in($alias . 'gm.' . $parameterValueLevel, $parameterValue))
                                           ->getDQL();
                } elseif ('' !== $parameterValue) {
                    $dql = $discriminatorQB->select($alias . 'gm.id')
                                           ->from(static::CLASS_MAP[$parameterValueClass], $alias . 'gm')
                                           ->andWhere($queryBuilder->expr()->eq($alias . 'gm.' . $parameterValueLevel, $parameterValue))
                                           ->getDQL();
                }
        }

        // If we already had the query for different game type then use orX instead andX;
        if (strpos($queryBuilder->getQuery()->getSQL(), '.type IN')) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->andX(
                    $queryBuilder->expr()->isInstanceOf($parameterValueName, $parameter),
                    $queryBuilder->expr()->in(
                        $parameterValueName . '.id',
                        $dql
                    )
                )
            );
        } else {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->andX(
                    $queryBuilder->expr()->isInstanceOf($parameterValueName, $parameter),
                    $queryBuilder->expr()->in(
                        $parameterValueName . '.id',
                        $dql
                    )
                )
            );
        }

        $parameterValue = $parameterValueClass;

        $queryBuilder->setParameter($parameter, $parameterValue);
    }
}