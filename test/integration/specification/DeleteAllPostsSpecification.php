<?php
namespace Test\Integration\Specification;
use Doctrine\ORM\QueryBuilder;
use RiftRunBundle\ORM\Specification\Specification;

final class DeleteAllPostsSpecification implements Specification
{
    public function __invoke(QueryBuilder $queryBuilder)
    {
        $queryBuilder->delete('RiftRunners:Post', 'p');
        return $queryBuilder;
    }
}