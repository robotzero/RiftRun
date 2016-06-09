<?php

namespace RiftRunBundle\ORM\Specification;

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\QueryBuilder;

final class OldPostsSpecification implements Specification
{
    /*
     * @param QueryBuilder $queryBuilder
     * @return QueryBuilder
     */
    public function __invoke(QueryBuilder $queryBuilder)
    {
        $queryBuilder->select('posts')
            ->innerJoin('posts.query', 'q')
            ->innerJoin('posts.player', 'p')
            ->innerJoin('q.game', 'g')
            ->innerJoin('q.characterType', 'ct')
            ->orderBy('posts.createdAt', 'desc')
            ->add('where', 'posts.createdAt < :createdAt')
            ->setParameter('createdAt', new \DateTime('-1 month'), Type::DATETIME);

        return $queryBuilder;
    }
}