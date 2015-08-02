<?php

namespace RiftRunBundle\Forms;

use RiftRunBundle\Forms\CharacterTypeType;
use RiftRunBundle\Forms\GriftType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchQueryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'characterType',
            'collection',
            [
                'type' => new CharacterTypeType(),
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => false
            ]
        );
        $builder->add('minParagon', 'integer');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RiftRunBundle\Model\SearchQuery',
            'csrf_protection' => false,
            'allow_extra_fields' => true
        ));
    }

    public function getName()
    {
        return 'searchquery';
    }
}
