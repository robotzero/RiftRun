<?php

namespace spec\RiftRunBundle\ORM\Specification;

use Doctrine\ORM\QueryBuilder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AllPostsSpecificationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('RiftRunBundle\ORM\Specification\AllPostsSpecification');
    }

    function it_implements_an_interface()
    {
        $this->shouldImplement('RiftRunBundle\ORM\Specification\Specification');
    }

    function it_should_build_fetch_all_posts_query(QueryBuilder $queryBuilder)
    {
        $queryBuilder->select('posts')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->innerJoin('posts.query', 'q')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->innerJoin('posts.player', 'p')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->innerJoin('q.game', 'g')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->innerJoin('q.characterType', 'ct')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->orderBy('posts.createdAt', 'desc')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->add('where', 'posts.createdAt > :createdAt')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setParameter('createdAt', Argument::type('\DateTime'), 'datetime')
                     ->shouldBeCalled()->willReturn($queryBuilder);

        $this->__invoke($queryBuilder);
    }
}
