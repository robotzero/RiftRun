<?php

namespace RiftRunBundle\Forms;

use RiftRunBundle\DTO\GriftDTO;
use RiftRunBundle\Model\Grift;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GriftType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('level', TextType::class, ['required' => true]);
        $builder->add('type', TextType::class, [ 'required' => true, 'mapped' => false ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RiftRunBundle\DTO\GriftDTO',
            'csrf_protection' => false,
        ));
    }

    public function getName()
    {
        return 'grift';
    }
}
