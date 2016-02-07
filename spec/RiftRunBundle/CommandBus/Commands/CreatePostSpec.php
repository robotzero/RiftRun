<?php

namespace spec\RiftRunBundle\CommandBus\Commands;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use RiftRunBundle\Model\Character;
use RiftRunBundle\Model\Post;
use RiftRunBundle\Model\SearchQuery;
use RiftRunBundle\Model\GameType;

class CreatePostSpec extends ObjectBehavior
{
    private $post;

    function let()
    {
        $this->post = new Post(
            new Character(1, 2, 3, 4, 5, 6, new \DateTime('now')),
            new SearchQuery(1, new GameType(), new \DateTime('now')),
            new \DateTime('now')
        );

        $this->beConstructedWith($this->post);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('RiftRunBundle\CommandBus\Commands\CreatePost');
    }

    function it_implements_an_interface()
    {
        $this->shouldHaveType('RiftRunBundle\CommandBus\Commands\Create');
    }

    function it_returns_post_object()
    {
        $this->getPost()->shouldReturn($this->post);
    }
}
