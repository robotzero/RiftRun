<?php

namespace RiftRunBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CharacterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type', 'text');
        $builder->add('paragonPoints', 'integer');
        $builder->add('battleTag', 'text');
        $builder->add('region', 'text');
        $builder->add('seasonal', 'text');
        $builder->add('gameType', 'text');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RiftRunBundle\Model\Character',
            'csrf_protection' => false,
        ));
    }

    public function getName()
    {
        return 'character';
    }
}