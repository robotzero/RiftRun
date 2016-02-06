<?php

namespace RiftRunBundle\CommandBus\Handlers;

use RiftRunBundle\CommandBus\Commands\ProcessForm;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class ProcessFormCommandHandler
{
    private $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function handle(ProcessForm $processForm)
    {
        $form = $this->formFactory->create(
            $processForm->getFormType(),
            null,
            ['method' => $processForm->getRequestMethod()]
        );

        $form->submit($processForm->getRequest()->request->all(), false);

        if ($form->isValid() === false) {
            $iterator = $form->getErrors(true, true);
            throw new BadRequestHttpException('Invalid form ' . (string) $iterator);
        }

        $processForm->setPost($form->getData());

        return $form->getData();
    }
}