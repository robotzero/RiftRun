<?php

namespace RiftRunBundle\Helpers;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;

final class FormErrors implements FormErrorsInterface
{
    /**
     * @param FormInterface $form
     * @return array
     */
    public function getAllErrors(FormInterface $form):array
    {
        return $this->getErrors($form, $form->getName());
    }

    private function getErrors(FormInterface $baseForm, string $baseFormName):array
    {
        $errors = array();
        if ($baseForm instanceof Form) {
            foreach($baseForm->getErrors() as $error) {
                $errors[] = array(
                    'mess' => $error->getMessage(),
                    'key'  => $baseFormName
                );
            }

            foreach ($baseForm->all() as $key => $child) {
                if ($child instanceof Form) {
                    $cErrors = $this->getErrors($child, $baseFormName . '_' . $child->getName());
                    $errors = array_merge($errors, $cErrors);
                }
            }
        }
        return $errors;
    }
}