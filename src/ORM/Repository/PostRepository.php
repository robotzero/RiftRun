<?php

namespace App\ORM\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * PostRepository
 *
 */
class PostRepository extends EntityRepository implements Repository
{
    /** @inheritdoc */
    public function match(Callable $criteria, $searchCriteria):QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('posts');

        return call_user_func_array($criteria, [$queryBuilder, $searchCriteria]);
    }
}
