<?php

namespace RiftRunBundle\ORM\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * PostRepository
 *
 */
class PostRepository extends EntityRepository
{
    public function match(Callable $criteria, $searchCriteria)
    {
        $queryBuilder = $this->createQueryBuilder('posts');

        return call_user_func_array($criteria, [$queryBuilder, $searchCriteria]);
    }
}
