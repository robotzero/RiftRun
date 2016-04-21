<?php

namespace RiftRunBundle\Helpers;

use Symfony\Component\Form\FormInterface;

interface FormErrorsInterface
{
    /**
     * @param FormInterface $form
     * @return array
     */
    public function getAllErrors(FormInterface $form):array;
}