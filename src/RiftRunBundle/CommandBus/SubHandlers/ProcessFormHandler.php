<?php

namespace RiftRunBundle\CommandBus\SubHandlers;

use RiftRunBundle\CommandBus\Commands\CreatePost;
use RiftRunBundle\CommandBus\Handlers\CommandHandler;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class ProcessFormHandler implements CommandHandler
{
    private $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function handle(CreatePost $createPost)
    {
        $form = $this->formFactory->create(
            $createPost->getFormType(),
            null,
            ['method' => $createPost->getRequestMethod()]
        );

        $form->submit($createPost->getRequestData(), true);

        if ($form->isValid() === false) {
            $iterator = $form->getErrors(true, true);
            throw new BadRequestHttpException('Invalid form ' . (string) $iterator);
        }

        return $form->getData();
    }
}