<?php

namespace RiftRunBundle\ORM\Specification;

use Doctrine\ORM\QueryBuilder;

final class AllPostsSpecification implements Specification
{
    public function __invoke(QueryBuilder $queryBuilder)
    {
        $queryBuilder->select('posts')->where(
            'posts.query != 0'
        );

        return $queryBuilder;
    }
}
