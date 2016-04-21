<?php

namespace RiftRunBundle\CommandBus\SubHandlers;

use RiftRunBundle\CommandBus\Commands\CreatePost;
use RiftRunBundle\CommandBus\Handlers\CommandHandler;
use RiftRunBundle\DTO\PostDTO;
use RiftRunBundle\Helpers\FormErrors;
use Symfony\Component\Form\Exception\AlreadySubmittedException;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;

final class ProcessFormHandler implements CommandHandler
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @param CreatePost $createPost
     * @throws InvalidOptionsException
     * @throws AlreadySubmittedException
     * @throws BadRequestHttpException
     * @return PostDTO
     */
    public function handle(CreatePost $createPost):PostDTO
    {
        $form = $this->formFactory->create(
            $createPost->getFormType(),
            null,
            ['method' => $createPost->getRequestMethod()]
        );

        $form->submit($createPost->getRequestData(), true);

        if ($form->isValid() === false) {
            $formHelper = new FormErrors();
            print_r($formHelper->getAllErrors($form));

            throw new BadRequestHttpException('Invalid form ' . (string) $iterator->__toString());
        }

        return $form->getData();
    }

    private function getAllFormErrors(FormInterface $form)
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