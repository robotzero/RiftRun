<?php

namespace App\Infrastructure\Common\Doctrine\ORM;

use App\Domain\GameMode\Model\Bounty;
use App\Domain\GameMode\Model\Grift;
use App\Domain\GameMode\Model\Keywarden;
use App\Domain\GameMode\Model\Rift;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Interface CriteriaOperator
 * @package Infrastructure\Common\Doctrine\ORM
 */
interface CriteriaOperator
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
     * @param ObjectRepository $repository
     */
    public function applyCriteria(QueryBuilder $queryBuilder, array $keys, array $operators, array $values, ObjectRepository $repository = null): void;
}