<?php

namespace App\Infrastructure\Common\Doctrine\ORM;

use App\Domain\GameMode\Model\Bounty;
use App\Domain\GameMode\Model\Grift;
use App\Domain\GameMode\Model\Keywarden;
use App\Domain\GameMode\Model\Rift;
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
     * @param array $values
     * @param QueryBuilder|null $discriminatorQB
     * @param string[] $criteria
     */
    public function applyCriteria(QueryBuilder $queryBuilder, array $values, QueryBuilder $discriminatorQB = null, string ...$criteria): void;
}