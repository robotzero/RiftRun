<?php

namespace spec\RiftRunBundle\CommandBus\Handlers;

use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use RiftRunBundle\CommandBus\Commands\Create;
use RiftRunBundle\Forms\PostType;
use RiftRunBundle\Model\Post;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class CreatePostCommandHandlerSpec extends ObjectBehavior
{
    private $formMock;

    private $formFactory;

    function let(
        FormFactory $formFactory,
        EntityManagerInterface $entityManager,
        PostType $postFormType,
        RequestStack $requestStack,
        Request $request,
        Form $form
    ) {
        $requestStack->getCurrentRequest()->willReturn($request);

        $this->formFactory = $formFactory;

        $this->formFactory->create(
            $postFormType,
            Argument::type('RiftRunBundle\Model\Post'), ['method' => 'POST']
        )->willReturn($form);

        $request->getContent()->willReturn("{'something':'value','other':'value'}");

        $this->formMock = $form;

        $this->beConstructedWith(
            $this->formFactory,
            $entityManager,
            $postFormType,
            $requestStack
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('RiftRunBundle\CommandBus\Handlers\CreatePostCommandHandler');
    }

    function it_delegates_to_formFactory_to_create_new_form(Create $createPost)
    {
        $createPost->getModel()->willReturn(new Post());
        $this->handle($createPost);

        $this->formMock->submit("{'something':'value','other':'value'}", true)->shouldHaveBeenCalledTimes(1);
    }

    function it_delegates_to_entity_manager_to_persist_new_post_data(EntityManagerInterface $entityManager, Create $createPost)
    {
        $post = new Post();
        $createPost->getModel()->willReturn($post);

        $this->formMock->submit(
            "{'something':'value','other':'value'}",
            true
        )->willReturn($post);

        $this->handle($createPost);

        $entityManager->persist($post)->shouldHaveBeenCalledTimes(1);
        $entityManager->flush($post)->shouldHaveBeenCalledTimes(1);
    }

    function it_catches_an_exception_when_persist_fails(EntityManagerInterface $entityManager, Create $createPost)
    {
        $post = new Post();
        $createPost->getModel()->willReturn($post);
        $entityManager->persist($post)->willThrow(new \InvalidArgumentException('Some message'));

        $this->handle($createPost);
    }

    function it_returns_redirect_response(Create $createPost)
    {
        $post = new Post();
        $createPost->getModel()->willReturn($post);

        $this->handle($createPost)->shouldHaveType('Symfony\Component\HttpFoundation\RedirectResponse');
    }

}
