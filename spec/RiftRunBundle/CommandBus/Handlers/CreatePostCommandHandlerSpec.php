<?php

namespace spec\RiftRunBundle\CommandBus\Handlers;

use Doctrine\ORM\EntityManagerInterface;
use League\Pipeline\Pipeline;
use League\Pipeline\PipelineInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use RiftRunBundle\CommandBus\Commands\Create;
use RiftRunBundle\CommandBus\Pipelines\PipelineManagerInterface;
use RiftRunBundle\Model\Post;
use Symfony\Component\Form\Form;

class CreatePostCommandHandlerSpec extends ObjectBehavior
{
    /** @var Post */
    private $post;

    function let(
        EntityManagerInterface $entityManager,
        PipelineManagerInterface $pipelineManager
    ) {
        $this->post = new FakePost();

        $this->beConstructedWith(
            $entityManager,
            $pipelineManager
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('RiftRunBundle\CommandBus\Handlers\CreatePostCommandHandler');
    }

    function it_delegates_to_entity_manager_to_persist_new_post_data(
        EntityManagerInterface $entityManager,
        PipelineManagerInterface $pipelineManager,
        Pipeline $pipeline,
        Create $createPost
    ) {
        $pipelineManager->build(['processFormPipe' => 'form.factory', 'transformDTOPipe' => null])->willReturn($pipeline);
        $pipeline->process($createPost)->willReturn($this->post);

        $this->handle($createPost);

        $entityManager->persist($this->post)->shouldHaveBeenCalledTimes(1);
        $entityManager->flush()->shouldHaveBeenCalledTimes(1);
    }

    function it_catches_an_exception_when_persist_fails(
        EntityManagerInterface $entityManager,
        PipelineManagerInterface $pipelineManager,
        Pipeline $pipeline,
        Create $createPost
    ) {
        $pipelineManager->build(['processFormPipe' => 'form.factory', 'transformDTOPipe' => null])->willReturn($pipeline);
        $pipeline->process($createPost)->willReturn($this->post);

        $entityManager->persist($this->post)->willThrow(new \InvalidArgumentException('Some message'));

        $this->handle($createPost);
    }

    function it_returns_saved_post(
        PipelineManagerInterface $pipelineManager,
        Pipeline $pipeline,
        Create $createPost
    ) {
        $pipelineManager->build(['processFormPipe' => 'form.factory', 'transformDTOPipe' => null])->willReturn($pipeline);
        $pipeline->process($createPost)->willReturn($this->post);

        $this->handle($createPost)->shouldHaveType('spec\RiftRunBundle\CommandBus\Handlers\FakePost');
    }
}

class FakePost extends Post
{
    public function __construct()
    {
    }
}
