<?php

namespace RiftRunBundle\ORM\Specification;

use Doctrine\ORM\QueryBuilder;

final class AllPostsSpecification implements Specification
{
    public function __invoke(QueryBuilder $queryBuilder)
    {
        $queryBuilder->select('posts')
                     ->innerJoin('posts.query', 'q')
                     ->innerJoin('posts.player', 'p')
                     ->innerJoin('q.game', 'g')
                     ->innerJoin('q.characterType', 'ct')
                     ->orderBy('posts.createdAt', 'desc')
                     ->add('where', 'posts.createdAt > :createdAt')
                     ->setParameter('createdAt', new \DateTime('-1 month'), \Doctrine\DBAL\Types\Type::DATETIME);

        return $queryBuilder;
    }
}
