<?php

namespace RiftRunBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use RiftRunBundle\Model\CharacterType as ModelCharacterType;

class CharacterTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type', TextType::class, ['required' => true]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RiftRunBundle\Model\CharacterType',
            'empty_data' => function (FormInterface $form) {
                return new ModelCharacterType(
                    $form->get('type')->getData()
                );
            },
            'csrf_protection' => false,
        ));
    }

    public function getName()
    {
        return 'charactertype';
    }
}
