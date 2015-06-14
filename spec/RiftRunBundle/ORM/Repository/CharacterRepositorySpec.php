<?php

namespace spec\RiftRunBundle\ORM\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\QueryBuilder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CharacterRepositorySpec extends ObjectBehavior
{
    function let(EntityManagerInterface $em, ClassMetadata $meta)
    {
        $this->beConstructedWith($em, $meta);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType('RiftRunBundle\ORM\Repository\CharacterRepository');
    }

    function it_calls_criteria_on_query_builder(EntityManagerInterface $em, QueryBuilder $qb)
    {
        $em->createQueryBuilder()->shouldBeCalled()->willReturn($qb);
        $qb->select('character')->shouldBeCalled()->willReturn($qb);
        $qb->from(Argument::any(), Argument::any(), Argument::any())->shouldBeCalled()->willReturn($qb);
        $qb->select()->shouldBeCalled();
        $qb->setParameter(1, '')->shouldBeCalled();
        $result = $this->match(function ($qb) {
            $qb->select();
            $qb->setParameter(1, '');

            return $qb;
        });

        $result->shouldHaveType('Doctrine\ORM\QueryBuilder');
    }
}
