<?php

namespace RiftRunBundle\Forms;

use RiftRunBundle\Forms\GameType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchQueryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('game', new GameType());
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
