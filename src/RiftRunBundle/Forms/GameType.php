<?php

namespace RiftRunBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class GameType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RiftRunBundle\Model\GameType',
            'csrf_protection' => false,
        ));
    }

    public function getName()
    {
        return 'game';
    }
}
