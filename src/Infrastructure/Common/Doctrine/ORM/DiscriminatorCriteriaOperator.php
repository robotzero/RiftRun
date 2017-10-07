<?php

namespace App\Infrastructure\Common\Doctrine\ORM;

use App\Infrastructure\Common\Exception\Doctrine\ORM\CriteriaOperatorException;
use Doctrine\ORM\QueryBuilder;

class DiscriminatorCriteriaOperator implements CriteriaOperator
{

    /**
     * @param QueryBuilder $queryBuilder
     * @param array $values
     * @param QueryBuilder|null $discriminatorQB
     * @param string[] $criteria
     * @return QueryBuilder
     * @throws \App\Infrastructure\Common\Exception\Doctrine\ORM\CriteriaOperatorException
     */
    public function applyCriteria(QueryBuilder $queryBuilder, array $values, QueryBuilder $discriminatorQB = null, string ...$criteria): QueryBuilder
    {
        [$operation, $name, $parameter, $parameterValue] = $criteria;
        [$parameterValueName, $parameterValueClass, $parameterValueLevel] = explode('.', $name);

        switch ($operation) {

            case static::OPERATOR_GT:
                $dql = $discriminatorQB->select('gm.id')
                                       ->from(static::CLASS_MAP[$parameterValueClass], 'gm')
                                       ->andWhere($queryBuilder->expr()->gt('gm.' . $parameterValueLevel, $parameterValue))
                                       ->getDQL();
                break;

            case static::OPERATOR_LT:
                $dql = $discriminatorQB->select('gm.id')
                                       ->from(static::CLASS_MAP[$parameterValueClass], 'gm')
                                       ->andWhere($queryBuilder->expr()->lt('gm.' . $parameterValueLevel, $parameterValue))
                                       ->getDQL();
                break;

            case static::OPERATOR_GTE:
                $dql = $discriminatorQB->select('gm.id')
                                       ->from(static::CLASS_MAP[$parameterValueClass], 'gm')
                                       ->andWhere($queryBuilder->expr()->gte('gm.' . $parameterValueLevel, $parameterValue))
                                       ->getDQL();
                break;

            case static::OPERATOR_LTE:
                $dql = $discriminatorQB->select('gm.id')
                                       ->from(static::CLASS_MAP[$parameterValueClass], 'gm')
                                       ->andWhere($queryBuilder->expr()->lte('gm.' . $parameterValueLevel, $parameterValue))
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
                    $dql = $discriminatorQB->select('gm.id')
                                           ->from(static::CLASS_MAP[$parameterValueClass], 'gm')
                                           ->andWhere($queryBuilder->expr()->in('gm.' . $parameterValueLevel, $parameterValue))
                                           ->getDQL();
                } elseif ('' !== $parameterValue) {
                    $dql = $discriminatorQB->select('gm.id')
                                           ->from(static::CLASS_MAP[$parameterValueClass], 'gm')
                                           ->andWhere($queryBuilder->expr()->eq('gm.' . $parameterValueLevel, $parameterValue))
                                           ->getDQL();
                }
        }

        $queryBuilder->andWhere($queryBuilder->expr()->andX(
            $queryBuilder->expr()->isInstanceOf($parameterValueName, $parameter),
            $queryBuilder->expr()->in(
                $parameterValueName . '.id',
                $dql
            )
        ));

        $parameterValue = $parameterValueClass;

        $queryBuilder->setParameter($parameter, $parameterValue);

        return $queryBuilder;
    }
}