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
        Form $form
    ) {
        $request = new Request();
        $requestStack->getCurrentRequest()->willReturn($request);

//        $this->formFactory = $formFactory;
//
//        $formFactory->create(
//            $postFormType,
//            null,
//            ['method' => 'POST']
//        )->willReturn($form);

        //$this->formMock = $form;

        $this->beConstructedWith(
            $formFactory,
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
        PostType $postFormType,
        RequestStack $requestStack,
        FormFactory $formFactory,
        Form $form
    ) {
        $post = new Post();
        $createPost->getModel()->willReturn($post);

        $formFactory->create(
            $postFormType,
            $post,
            ['method' => 'POST']
        )->willReturn($form);

        $form->handleRequest(
            Argument::type('Symfony\Component\HttpFoundation\Request')
        )->shouldBeCalledTimes(1);

        $form->isValid()->willReturn(true);
        $this->handle($createPost);

        $entityManager->persist($post)->shouldHaveBeenCalledTimes(1);
        $entityManager->flush($post)->shouldHaveBeenCalledTimes(1);
    }

//    function it_catches_an_exception_when_persist_fails(EntityManagerInterface $entityManager, Create $createPost)
//    {
//        $post = new Post();
//        $createPost->getModel()->willReturn($post);
//        $entityManager->persist($post)->willThrow(new \InvalidArgumentException('Some message'));
//
//        $this->handle($createPost);
//    }
//
//    function it_returns_redirect_response(Create $createPost)
//    {
//        $post = new Post();
//        $createPost->getModel()->willReturn($post);
//
//        $this->handle($createPost)->shouldHaveType('Symfony\Component\HttpFoundation\RedirectResponse');
//    }

}
