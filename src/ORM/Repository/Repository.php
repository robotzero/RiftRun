<?php

namespace App\ORM\Repository;

use Doctrine\ORM\QueryBuilder;

interface Repository
{
    /**
     * @param callable $criteria
     * @param $searchCriteria
     * @return QueryBuilder
     */
    public function match(Callable $criteria, $searchCriteria):QueryBuilder;
}