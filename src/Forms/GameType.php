<?php

namespace App\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

abstract class GameType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RiftRunBundle\DTO\GameTypeDTO',
            'csrf_protection' => false,
            'constraints' => new Valid(),
        ));
    }

    public function getName()
    {
        return 'game';
    }
}
