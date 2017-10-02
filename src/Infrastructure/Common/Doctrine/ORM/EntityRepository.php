<?php

namespace App\Infrastructure\Common\Doctrine\ORM;

use App\Domain\GameMode\Model\Bounty;
use App\Domain\GameMode\Model\Grift;
use App\Domain\GameMode\Model\Keywarden;
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
    const CLASS_MAP = [
        'rift' => Rift::class,
        'grift' => Grift::class,
        'bounty' => Bounty::class,
        'keywarden' => Keywarden::class
    ];

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
                        if ($this->startsWith($name, 'game.')) {
                            [$parameterValueName, $parameterValueClass, $parameterValueLevel] = explode('.', $name);
                            $queryBuilder2 = $this->createQueryBuilder('gameMode');
                            $queryBuilder->andWhere($queryBuilder->expr()->andX(
                                $queryBuilder->expr()->isInstanceOf($parameterValueName, $parameter),
                                $queryBuilder->expr()->in(
                                    $parameterValueName . '.id',
                                    $queryBuilder2->select('gm.id')
                                                 ->from(static::CLASS_MAP[$parameterValueClass], 'gm')
                                                 ->where('gm. ' . $parameterValueLevel . ' >=' . $parameterValue)
                                                 ->getDQL())));
                            $parameterValue = $parameterValueClass;
                        } else  {
                            $queryBuilder->andWhere($queryBuilder->expr()->eq($name, $parameter));
                        }
                    }
            }
            $queryBuilder->setParameter($parameter, $parameterValue);
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