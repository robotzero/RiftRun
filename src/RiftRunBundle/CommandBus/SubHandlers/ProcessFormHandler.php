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

    /**
     * @var FormErrors
     */
    private $formErrorsHelper;

    public function __construct(FormFactoryInterface $formFactory, FormErrors $formErrorsHelper)
    {
        $this->formFactory = $formFactory;
        $this->formErrorsHelper = $formErrorsHelper;
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
            throw new BadRequestHttpException('Invalid form');
        }

        return $form->getData();
    }
}