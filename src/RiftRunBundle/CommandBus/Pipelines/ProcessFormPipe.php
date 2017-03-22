<?php

namespace RiftRunBundle\CommandBus\Pipelines;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\ConstraintViolation;

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
     * @return mixed
     * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     * @throws \Symfony\Component\Form\Exception\AlreadySubmittedException
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function __invoke($payloadData)
    {
        $form = $this->formFactory->create(
            $payloadData->getFormType(),
            null,
            ['method' => $payloadData->getRequestMethod()]
        );

        $form = $form->submit($payloadData->getRequestData(), true);

        if ($form->isValid() === false) {
            $errorsIterator = $form->getErrors(true, true);
            do {
                $formError = $errorsIterator->current();
                /** @var ConstraintViolation $constraint */
                $constraint = $formError->getCause();
                $message[] =  $constraint->getMessageTemplate();
                $property[] = $constraint->getPropertyPath();
                $errorsIterator->next();
            } while ($errorsIterator->current());
            print_r($message);
            print_r($property);
            throw new BadRequestHttpException('Invalid form:');
        }
        return $form->getData();
    }
}