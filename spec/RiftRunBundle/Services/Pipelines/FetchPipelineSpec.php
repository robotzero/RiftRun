<?php

namespace spec\RiftRunBundle\Services\Pipelines;

use Doctrine\ORM\QueryBuilder;
use RiftRunBundle\ORM\Repository\Repository;
use RiftRunBundle\ORM\Specification\Specification;
use RiftRunBundle\Services\Criteria\FetchCriteria;
use RiftRunBundle\Services\Pipelines\FetchPipeline;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Bridge\Doctrine\RegistryInterface;

class FetchPipelineSpec extends ObjectBehavior
{
    function let(FetchCriteria $criteria)
    {
        $this->beConstructedWith($criteria);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(FetchPipeline::class);
    }

    function it_should_implement_an_interface()
    {
        $this->shouldImplement('RiftRunBundle\Services\Pipelines\ServicePipeline');
    }

    function it_should_fetch_correct_repository_based_on_passed_criteria(
        FetchCriteria $criteria,
        RegistryInterface $doctrine,
        Repository $repository,
        SpecificationFake $specification
    ) {
        $criteria->getRepositoryName()->willReturn('NameSpace:RepoName');
        $criteria->getSpecification()->willReturn($specification);
        $criteria->getDoctrine()->willReturn($doctrine);
        $doctrine->getRepository('NameSpace:RepoName')->shouldBeCalledTimes(1)->willReturn($repository);
        $repository->match($specification, null)->shouldBeCalledTimes(1);
        $this->__invoke();
    }

    function it_delegates_to_repository_to_get_the_query_builder(
        FetchCriteria $criteria,
        RegistryInterface $doctrine,
        Repository $repository,
        SpecificationFake $specification,
        QueryBuilder $queryBuilder
    ) {
        $criteria->getRepositoryName()->shouldBeCalledTimes(1);
        $criteria->getSpecification()->willReturn($specification);
        $criteria->getDoctrine()->willReturn($doctrine);
        $doctrine->getRepository('')->willReturn($repository);
        $repository->match($specification, null)->willReturn($queryBuilder);
        $this->__invoke()->shouldReturnAnInstanceOf('Doctrine\ORM\QueryBuilder');
    }
}

class SpecificationFake implements Specification { public function __invoke() {} }
