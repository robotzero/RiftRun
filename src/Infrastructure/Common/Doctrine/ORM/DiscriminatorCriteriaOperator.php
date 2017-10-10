<?php

namespace App\Infrastructure\Common\Doctrine\ORM;

use App\Infrastructure\Common\Exception\Doctrine\ORM\CriteriaOperatorException;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\QueryBuilder;

class DiscriminatorCriteriaOperator implements CriteriaOperator
{

    /**
     * @param QueryBuilder $queryBuilder
     * @param array $keys
     * @param array $operators
     * @param array $values
     * @param ObjectRepository|null $objectRepository
     * @throws CriteriaOperatorException
     */
    public function applyCriteria(QueryBuilder $queryBuilder, array $keys, array $operators, array $values, ObjectRepository $objectRepository = null): void
    {
        $dql = [];
        foreach ($keys as $position => $value) {
            if (null === $value) {
                continue;
            }

            $name = $value;
            $parameter = ':' . str_replace('.', '_', $value) . $position;
            $operation = $operators[ $position ];
            $parameterValue = $values[ $position ];

            [$parameterValueName, $parameterValueClass, $parameterValueLevel] = explode('.', $name);
            $alias = $parameterValueName . $parameterValueClass;
            $discriminatorQB = $objectRepository->createQueryBuilder('gameMode' . $position);
            switch ($operation) {
                case static::OPERATOR_GT:
                    $dql[$parameterValueClass]['dql'] = $discriminatorQB->select($alias . 'gm.id')
                        ->from(static::CLASS_MAP[ $parameterValueClass ], $alias . 'gm')
                        ->andWhere($queryBuilder->expr()->gt($alias . 'gm.' . $parameterValueLevel, $parameterValue))
                        ->getDQL();
                    break;

                case static::OPERATOR_LT:
                    $dql[$parameterValueClass]['dql'] = $discriminatorQB->select($alias . 'gm.id')
                        ->from(static::CLASS_MAP[ $parameterValueClass ], $alias . 'gm')
                        ->andWhere($queryBuilder->expr()->lt($alias . 'gm.' . $parameterValueLevel, $parameterValue))
                        ->getDQL();
                    break;

                case static::OPERATOR_GTE:
                    $dql[$parameterValueClass]['dql'] = $discriminatorQB->select($alias . 'gm.id')
                        ->from(static::CLASS_MAP[ $parameterValueClass ], $alias . 'gm')
                        ->andWhere($queryBuilder->expr()->gte($alias . 'gm.' . $parameterValueLevel, $parameterValue))
                        ->getDQL();
                    break;

                case static::OPERATOR_LTE:
                    $dql[$parameterValueClass]['dql'] = $discriminatorQB->select($alias . 'gm.id')
                        ->from(static::CLASS_MAP[ $parameterValueClass ], $alias . 'gm')
                        ->andWhere($queryBuilder->expr()->lte($alias . 'gm.' . $parameterValueLevel, $parameterValue))
                        ->getDQL();
                    break;

                case static::OPERATOR_LIKE:
                    throw new CriteriaOperatorException(static::OPERATOR_LIKE . ' is not supported on discriminator column.');

                case static::OPERATOR_BETWEEN:
                    throw new CriteriaOperatorException(static::OPERATOR_BETWEEN . ' is not supported on discriminator column.');
                    break;

                case static::OPERATOR_EQ:

                default:
                    if (null === $parameterValue) {
                        throw new CriteriaOperatorException('null value is not supported on discriminator column.');
                    }

                    if (is_array($parameterValue)) {
                        $dql[$parameterValueClass]['dql'] = $discriminatorQB->select($alias . 'gm.id')
                            ->from(static::CLASS_MAP[ $parameterValueClass ], $alias . 'gm')
                            ->andWhere($queryBuilder->expr()->in($alias . 'gm.' . $parameterValueLevel, $parameterValue))
                            ->getDQL();
                    } elseif ('' !== $parameterValue) {
                        $dql[$parameterValueClass]['dql'] = $discriminatorQB->select($alias . 'gm.id')
                            ->from(static::CLASS_MAP[ $parameterValueClass ], $alias . 'gm')
                            ->andWhere($queryBuilder->expr()->eq($alias . 'gm.' . $parameterValueLevel, $parameterValue))
                            ->getDQL();
                    }
            }
            $dql[$parameterValueClass]['parameterValueName'] = $parameterValueName;
            $dql[$parameterValueClass]['parameter'] = $parameter;
            $dql[$parameterValueClass]['parameterValue'] = $parameterValue;
        }

        $or = $queryBuilder->expr()->orX();

        foreach ($dql as $key => $value) {
            $or->add($queryBuilder->expr()->andX(
               $queryBuilder->expr()->isInstanceOf($value['parameterValueName'], $value['parameter']),
               $queryBuilder->expr()->in($value['parameterValueName'] . '.id', $value['dql'])
            ));
            $queryBuilder->setParameter($value['parameter'], $key);
        }
        $queryBuilder->andWhere($or);
    }
}