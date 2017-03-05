<?php
namespace Test\Integration\Specification;
use Doctrine\ORM\QueryBuilder;
use RiftRunBundle\ORM\Specification\Specification;

final class DeleteAllPostsSpecification implements Specification
{
    public function __invoke(QueryBuilder $queryBuilder)
    {
        $queryBuilder->select('posts')
                     ->innerJoin('posts.query', 'q')
                     ->innerJoin('posts.player', 'pl')
                     ->innerJoin('q.game', 'g')
                     ->innerJoin('q.characterType', 'ct');
        return $queryBuilder;
    }
}