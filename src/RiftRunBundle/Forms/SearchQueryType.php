<?php

namespace RiftRunBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchQueryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'characterType',
            CollectionType::class,
            [
                'entry_type' => CharacterTypeType::class,
                'allow_add' => true,
                'required' => true,
                'by_reference' => false,
                'allow_delete' => false
            ]
        );
        $builder->add('minParagon', IntegerType::class, ['required' => true]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RiftRunBundle\Model\SearchQuery',
            'csrf_protection' => false,
            'cascade_validation' => true
        ));
    }

    public function getName()
    {
        return 'searchquery';
    }
}
