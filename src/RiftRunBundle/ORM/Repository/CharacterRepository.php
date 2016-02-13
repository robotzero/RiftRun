<?php

namespace RiftRunBundle\ORM\Repository;

use Doctrine\ORM\EntityRepository;

class CharacterRepository extends EntityRepository
{
    public function match(Callable $criteria, \Object $searchCriteria)
    {
        $queryBuilder = $this->createQueryBuilder('character');

        return call_user_func($criteria, $queryBuilder);
    }
}
