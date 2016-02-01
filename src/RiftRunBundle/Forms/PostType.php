<?php

namespace RiftRunBundle\Forms;

use RiftRunBundle\Model\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
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
                $searchquery->add('game', GriftType::class, ['required' => true]);
            }
        });

        $builder->add('query', SearchQueryType::class, ['required' => true]);
        $builder->add('player', CharacterType::class, ['required' => true]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RiftRunBundle\Model\Post',
            'empty_data' => function (FormInterface $form) {
                return new Post(
                    $form->get('player')->getData(),
                    $form->get('query')->getData(),
                    new \DateTime('now')
                );
            },
            'csrf_protection' => false,
            'cascade_validation' => false
        ));
    }

    public function getName()
    {
        return 'post';
    }
}
