<?php

namespace RiftRunBundle\ORM\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * PostRepository
 *
 */
class PostRepository extends EntityRepository
{
    public function match(Callable $criteria)
    {
        $queryBuilder = $this->createQueryBuilder('posts');

        return call_user_func($criteria, $queryBuilder);
    }
}
