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

            $errors = $this->getAllFormErrors($form);

            dump($errors);
            throw new BadRequestHttpException('Invalid form ' . (string) $iterator->__toString());
        }

        return $form->getData();
    }

    private function getAllFormErrors($form)
    {
        $results = [];

        foreach ($form->getErrors() as $error) {
            $results[] = $error->getMessage();
        }

        foreach ($form->all() as $name => $child) {
            $results[$name] = $this->getAllFormErrors($child);
        }

        return $results;
    }
}