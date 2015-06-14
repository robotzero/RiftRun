<?php

namespace spec\RiftRunBundle\ORM\Specification;

use Doctrine\ORM\QueryBuilder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class WizardsSpecificationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('RiftRunBundle\ORM\Specification\WizardsSpecification');
    }

    function it_should_build_a_query(QueryBuilder $queryBuilder)
    {
        $queryBuilder->select('character')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->where('character.type=?1')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setParameter(1, 'wizard')->shouldBeCalled()->willReturn($queryBuilder);

        $this->__invoke($queryBuilder);
    }
}
