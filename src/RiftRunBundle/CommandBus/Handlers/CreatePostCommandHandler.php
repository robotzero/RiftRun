<?php

namespace RiftRunBundle\CommandBus\Handlers;

use Doctrine\ORM\EntityManagerInterface;
use RiftRunBundle\CommandBus\Commands\Create;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

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
        $form->submit(json_decode($currentRequest->getContent(), true), true);

        if ($form->isValid() === false) {
            $iterator = $form->getErrors(true, true);
            //echo $iterator->__toString();
            throw new BadRequestHttpException('Invalid form ' . $iterator->__toString());
        }

        try {
            $this->entityManager->persist($post);
            $this->entityManager->flush($post);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        //return [];
        return new RedirectResponse('posts', 302);
    }
}
