<?php

namespace spec\RiftRunBundle\CommandBus\Commands;

use PhpSpec\ObjectBehavior;

class CreatePostSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Bundle/ExampleType', 'GET', ['variable' => 'setting']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('RiftRunBundle\CommandBus\Commands\CreatePost');
    }

    function it_implements_an_interface()
    {
        $this->shouldHaveType('RiftRunBundle\CommandBus\Commands\Create');
    }

    function it_returns_formtype()
    {
        $this->getFormType()->shouldReturn('Bundle/ExampleType');
    }

    function it_returns_request_method()
    {
        $this->getRequestMethod()->shouldReturn('GET');
    }

    function it_returns_request_data()
    {
        $thi->getRequestData()->shouldReturn(['variable' => 'setting']);
    }
}
