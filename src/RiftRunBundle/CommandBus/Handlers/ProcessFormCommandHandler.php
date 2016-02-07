<?php

namespace RiftRunBundle\CommandBus\Handlers;

use RiftRunBundle\CommandBus\Commands\ProcessForm;
use RiftRunBundle\CommandBus\Events\PostFormEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class ProcessFormCommandHandler
{
    private $formFactory;
    private $eventDispatcher;

    public function __construct(FormFactoryInterface $formFactory, EventDispatcherInterface $eventDispatcher)
    {
        $this->formFactory = $formFactory;
        $this->eventDispatcher = $eventDispatcher;
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

        $this->eventDispatcher->dispatch('hydrate.form', new PostFormEvent($form->getData()));

        return $form->getData();
    }
}