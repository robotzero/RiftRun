<?php

namespace RiftRunBundle\Forms;

use RiftRunBundle\Forms\CharacterTypeType;
use RiftRunBundle\Forms\GameType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchQueryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();
            if ($data['game']['type'] === 'grift') {
                $form->add('game', new GriftType());
            }
        });

        $builder->add(
            'characterType',
            'collection',
            ['type' => new CharacterTypeType(), 'allow_add' => true, 'by_reference' => false]
        );
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
