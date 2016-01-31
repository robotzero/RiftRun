<?php

namespace RiftRunBundle\Forms;

use RiftRunBundle\Model\Character;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CharacterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type', TextType::class, ['required' => true]);
        $builder->add('paragonPoints', IntegerType::class, ['required' => true]);
        $builder->add('battleTag', TextType::class, ['required' => true]);
        $builder->add('region', TextType::class, ['required' => true]);
        $builder->add('seasonal', TextType::class, ['required' => true]);
        $builder->add('gameType', TextType::class, ['required' => true]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RiftRunBundle\Model\Character',
            'empty_data' => function (FormInterface $form) {
                return new Character(
                    $form->get('type')->getData(),
                    $form->get('paragonPoints')->getData(),
                    $form->get('battleTag')->getData(),
                    $form->get('region')->getData(),
                    $form->get('seasonal')->getData(),
                    $form->get('gameType')->getData(),
                    new \DateTime('now')
                );
            },
            'csrf_protection' => false,
        ));
    }

    public function getName()
    {
        return 'character';
    }
}
