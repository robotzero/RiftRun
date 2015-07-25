<?php

namespace RiftRunBundle\ORM\Specification;

use Doctrine\ORM\QueryBuilder;

final class AllPostsSpecification implements Specification
{
    public function __invoke(QueryBuilder $queryBuilder)
    {
        $queryBuilder->select('posts')->innerJoin('posts.query', 'q');
        return $queryBuilder;
    }
}
