<?php

namespace RiftRunBundle\ORM\Specification;

use Doctrine\Common\Util\Debug;
use Doctrine\ORM\QueryBuilder;

final class SearchQuerySpecification implements Specification
{
    public function __invoke(QueryBuilder $queryBuilder, $searchCriteria)
    {
        $characterTypes = $searchCriteria->getCharacterType()->unwrap()->getValues();
        $types = [];

        foreach($characterTypes as $characterType) {
            array_push($types, $characterType->getType());
        }

        //@TODO get rid of this hack.
        $types = empty($types) ? [0] : $types;

        $queryBuilder->select('posts')
                     ->leftJoin('posts.player', 'p')
                     ->where('p.paragonPoints >= ' . $searchCriteria->getMinParagon())
                     ->andWhere(
                         $queryBuilder->expr()->in('p.type', $types)
                     )
                     ->orderBy('posts.createdAt', 'desc');

        return $queryBuilder;
    }

}