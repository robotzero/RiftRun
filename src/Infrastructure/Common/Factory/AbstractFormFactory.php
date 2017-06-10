<?php

namespace App\Infrastructure\Common\Factory;

use App\Infrastructure\Common\Exception\Form\FormFactoryException;
use App\Infrastructure\Common\Exception\Form\FormException;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;

/**
 * Class AbstractFactory
 * @package App\Infrastructure\Common\Factory
 */
abstract class AbstractFormFactory
{
    const
        CREATE = 'POST',
        REPLACE = 'PUT',
        UPDATE = 'PATCH'
    ;
    /**
     * @var FormFactory
     */
    protected $formFactory;

    /**
     * @var string
     */
    protected $formClass;

    public function __construct(FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;

        if (!$this->formClass) {

            throw new FormFactoryException();
        }
    }

    /**
     * @param string $action
     * @param array $data
     * @param null|object $object
     *
     * @return mixed
     * @throws \Symfony\Component\Form\Exception\AlreadySubmittedException
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     *
     * @throws FormException
     */
    protected function execute(string $action = self::CREATE, array $data, $object = null)
    {
        /** @var FormInterface $form */
        $form = $this->createForm($action, $object)->submit($data, self::UPDATE !== $action);
        if (!$form->isValid()) {
            throw new FormException($form);
        }
        return $form->getData();
    }

    /**
     * @param string $action
     * @param null|object $object
     *
     * @return FormInterface
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    private function createForm(string $action = self::CREATE, $object = null): FormInterface
    {
        return $this->formFactory->create($this->formClass, $object, [
            'method' => $action
        ]);
    }
}