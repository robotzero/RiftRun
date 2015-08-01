<?php

namespace RiftRunBundle\CommandBus\Handlers;

use Doctrine\ORM\EntityManagerInterface;
use RiftRunBundle\CommandBus\Commands\Create;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;

final class CreatePostCommandHandler
{
    /** @var FormFactory */
    private $formFactory;

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var AbstractType */
    private $postFormType;

    /** @var RequestStack */
    private $requestStack;

    public function __construct(
        FormFactory $formFactory,
        EntityManagerInterface $entityManager,
        AbstractType $postFormType,
        RequestStack $requestStack
    ) {
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->postFormType = $postFormType;
        $this->requestStack = $requestStack;
    }
    public function handle(Create $createPost)
    {
        $post = $createPost->getModel();

        $form = $this->formFactory->create(
            $this->postFormType,
            $post,
            ['method' => 'POST']
        );

        $currentRequest = $this->requestStack->getCurrentRequest();

        $form->submit($currentRequest->getContent(), true);

        try {
            $this->entityManager->persist($post);
            $this->entityManager->flush($post);
        } catch (\Exception $e) {
            // TODO send error response
        }

        return new RedirectResponse('posts', 302);
    }
}