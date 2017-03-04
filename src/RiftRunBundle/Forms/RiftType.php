<?php

namespace RiftRunBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;
use RiftRunBundle\DTO\RiftDTO;

class RiftType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('torment', NumberType::class, ['required' => true]);
        $builder->add('type', TextType::class, [ 'required' => true, 'mapped' => false ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => RiftDTO::class,
            'constraints' => new Valid(),
            'csrf_protection' => false,
        ));
    }

    public function getName()
    {
        return 'rift';
    }
}