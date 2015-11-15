<?php

namespace RiftRunBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CharacterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type', 'text', ['required' => true]);
//        $builder->add('paragonPoints', 'integer', ['required' => true]);
//        $builder->add('battleTag', 'text', ['required' => true]);
//        $builder->add('region', 'text', ['required' => true]);
//        $builder->add('seasonal', 'text', ['required' => true]);
//        $builder->add('gameType', 'text', ['required' => true]);
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
