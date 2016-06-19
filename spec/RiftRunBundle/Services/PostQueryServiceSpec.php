<?php

namespace spec\RiftRunBundle\Services;

use Doctrine\Common\Persistence\ObjectRepository;
use RiftRunBundle\Model\Post;
use RiftRunBundle\Services\PostQueryService;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PostQueryServiceSpec extends ObjectBehavior
{
    function let(RegistryInterface $doctrine)
    {
        $this->beConstructedWith($doctrine);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PostQueryService::class);
    }

    function it_should_implement_an_interface()
    {
        $this->shouldImplement('RiftRunBundle\Services\QueryService');
    }

    function it_delegates_to_doctrine_to_get_the_repository_and_post(RegistryInterface $doctrine, ObjectRepository $repository)
    {
        $doctrine->getRepository('RiftRunners:Post')->shouldBeCalled();
        $doctrine->getRepository('RiftRunners:Post')->willReturn($repository);
        $repository->findOneBy(['id' => 20])->willReturn(new FakePost());
        $this->query('Post', 20);
    }
}

class FakePost extends Post {public function __construct() {}}