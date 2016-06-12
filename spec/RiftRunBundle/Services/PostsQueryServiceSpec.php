<?php

namespace spec\RiftRunBundle\Services;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use RiftRunBundle\Services\PostsQueryService;

class PostsQueryServiceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PostsQueryService::class);
    }

    function it_should_implement_an_interface()
    {
        $this->shouldImplement('RiftRunBundle\Services\QueryService');
    }
}
