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
    private $form;
    private $post;
    private $formFactory;

    function let(
        FormFactory $formFactory,
        EntityManagerInterface $entityManager,
        PostType $postFormType,
        RequestStack $requestStack,
        Form $form,
        Create $createPost
    ) {
        $this->post = new Post();
        $createPost->getModel()->willReturn($this->post);
        $request = new Request();
        $requestStack->getCurrentRequest()->willReturn($request);
        $this->form = $form;
        $this->formFactory = $formFactory;

        $this->formFactory->create(
            $postFormType,
            $this->post,
            ['method' => 'POST']
        )->willReturn($this->form);

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

    function it_delegates_to_entity_manager_to_persist_new_post_data(
        EntityManagerInterface $entityManager,
        Create $createPost,
        Form $form
    ) {
        $this->form->handleRequest(
            Argument::type('Symfony\Component\HttpFoundation\Request')
        )->shouldBeCalledTimes(1);

        $this->form->isValid()->willReturn(true);
        $this->handle($createPost);

        $entityManager->persist($this->post)->shouldHaveBeenCalledTimes(1);
        $entityManager->flush($this->post)->shouldHaveBeenCalledTimes(1);
    }

    function it_catches_an_exception_when_persist_fails(
        EntityManagerInterface $entityManager,
        Create $createPost,
        Form $form
    ) {
        $this->form->handleRequest(
            Argument::type('Symfony\Component\HttpFoundation\Request')
        )->shouldBeCalledTimes(1);

        $this->form->isValid()->willReturn(true);

        $entityManager->persist($this->post)->willThrow(new \InvalidArgumentException('Some message'));

        $this->handle($createPost);
    }

    function it_returns_redirect_response(
        Create $createPost,
        Form $form
    ) {
        $this->form->handleRequest(
            Argument::type('Symfony\Component\HttpFoundation\Request')
        )->shouldBeCalledTimes(1);

        $this->form->isValid()->willReturn(true);

        $this->handle($createPost)->shouldHaveType('Symfony\Component\HttpFoundation\RedirectResponse');
    }

    function it_throws_an_exception_when_form_is_invalid(
        Create $createPost,
        Form $form
    ) {
        $this->form->handleRequest(
            Argument::type('Symfony\Component\HttpFoundation\Request')
        )->shouldBeCalledTimes(1);

        $this->form->isValid()->willReturn(false);
        $this->form->getErrors(true, true)->willReturn(Argument::type('\RecursiveIterator'));

        $this->shouldThrow('\Symfony\Component\HttpKernel\Exception\BadRequestHttpException')->during('handle', [$createPost]);
    }
}
