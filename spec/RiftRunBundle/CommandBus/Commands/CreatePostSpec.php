<?php

namespace spec\RiftRunBundle\CommandBus\Commands;

use PhpSpec\ObjectBehavior;

class CreatePostSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('RiftRunBundle\CommandBus\Commands\CreatePost');
    }

    function it_implements_an_interface()
    {
        $this->shouldHaveType('RiftRunBundle\CommandBus\Commands\Create');
    }

    function it_returns_new_post_model()
    {
        $result = $this->getModel();

        $this->getModel()->shouldHaveType('RiftRunBundle\Model\Post');
    }
}
