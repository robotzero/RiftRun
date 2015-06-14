<?php

namespace RiftRunBundle\ORM\Specification;

use Doctrine\ORM\QueryBuilder;

final class WizardsSpecification implements Specification
{
    public function __invoke(QueryBuilder $queryBuilder)
    {
        $queryBuilder->select('character')
                     ->where('character.type=?1')
                     ->setParameter(1, 'wizard');

        return $queryBuilder;
    }
}
