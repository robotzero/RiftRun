<?php

namespace RiftRunBundle\Forms;

use RiftRunBundle\Forms\CharacterType;
use RiftRunBundle\Forms\SearchQueryType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('query', new SearchQueryType());
        $builder->add('player', new CharacterType());
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RiftRunBundle\Model\Post',
            'csrf_protection' => false,
        ));
    }

    public function getName()
    {
        return 'post';
    }
}
