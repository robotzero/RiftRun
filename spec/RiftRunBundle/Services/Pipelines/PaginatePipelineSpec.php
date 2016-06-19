<?php

namespace spec\RiftRunBundle\Services\Pipelines;

use Hateoas\Configuration\Route;
use Hateoas\Representation\Factory\PagerfantaFactory;
use Hateoas\Representation\PaginatedRepresentation;
use Pagerfanta\Pagerfanta;
use RiftRunBundle\Services\Pipelines\PaginatePipeline;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PaginatePipelineSpec extends ObjectBehavior
{
    function let(Route $route, PagerfantaFactory $factory)
    {
        $this->beConstructedWith(12, 10, $route, $factory);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(PaginatePipeline::class);
    }

    function it_delegates_to_factory_to_create_representation(Route $route, Pagerfanta $pagerfanta, PagerfantaFactory $factory, PaginatedRepresentation $collection)
    {
        $factory->createRepresentation($pagerfanta, $route)->shouldBeCalled();
        $factory->createRepresentation($pagerfanta, $route)->willReturn($collection);
        $this->__invoke($pagerfanta);
    }

    function it_sets_pagination_values_on_pagerfanta_object(Route $route, Pagerfanta $pagerfanta, PagerfantaFactory $factory, PaginatedRepresentation $collection)
    {
        $factory->createRepresentation($pagerfanta, $route)->willReturn($collection);
        $this->__invoke($pagerfanta);
        $pagerfanta->setCurrentPage(12)->shouldHaveBeenCalled();
        $pagerfanta->setMaxPerPage(10)->shouldHaveBeenCalled();
    }
}
