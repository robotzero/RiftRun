<?php

namespace RiftRunBundle\Forms;

use RiftRunBundle\Forms\CharacterType;
use RiftRunBundle\Forms\SearchQueryType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();

            if (isset($data['query']['game']['type']) && $data['query']['game']['type'] === 'grift') {
                $searchquery = $form->get('query');
                $searchquery->add('game', new GriftType());
            }
        });

        $builder->add('query', new SearchQueryType());
        $builder->add('player', new CharacterType());
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RiftRunBundle\Model\Post',
            'csrf_protection' => false,
            'cascade_validation' => true
        ));
    }

    public function getName()
    {
        return 'post';
    }
}
