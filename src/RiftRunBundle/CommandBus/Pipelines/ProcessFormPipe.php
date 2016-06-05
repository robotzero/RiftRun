<?php

namespace RiftRunBundle\CommandBus\Pipelines;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ProcessFormPipe
{
    /** @var FormFactoryInterface */
    private $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @param mixed $payloadData
     */
    public function __invoke($payloadData)
    {
        $form = $this->formFactory->create(
            $payloadData->getFormType(),
            null,
            ['method' => $payloadData->getRequestMethod()]
        );

        $form->submit($payloadData->getRequestData(), true);

        if ($form->isValid() === false) {
            throw new BadRequestHttpException('Invalid form');
        }

        return $form->getData();
    }
}