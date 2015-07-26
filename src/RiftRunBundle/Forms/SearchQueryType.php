<?php

namespace RiftRunBundle\Forms;

use RiftRunBundle\Forms\GriftType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchQueryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('game', new GriftType());
        $builder->add('minParagon', 'integer');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RiftRunBundle\Model\SearchQuery',
            'csrf_protection' => false,
        ));
    }

    public function getName()
    {
        return 'searchquery';
    }
}
