<?php

namespace spec\RiftRunBundle\CommandBus\Commands;

use PhpSpec\ObjectBehavior;

class PagerfantaPaginateSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(1, 20, 'Post', 'default_route');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('RiftRunBundle\CommandBus\Commands\PagerfantaPaginate');
    }

    function it_returns_limit()
    {
        $this->getLimit()->shouldReturn(20);
    }

    function it_returns_page_number()
    {
        $this->getPageNumber()->shouldReturn(1);
    }

    function it_returns_repository_name()
    {
        $this->getRepositoryName()->shouldReturn('Post');
    }

    function it_returns_route()
    {
        $this->getRoute()->shouldReturnAnInstanceOf('Hateoas\Configuration\Route');
    }

    function it_returns_default_specification()
    {
        $this->getDefaultSpecification()->shouldReturnAnInstanceOf('RiftRunBundle\ORM\Specification\AllPostsSpecification');
    }
}