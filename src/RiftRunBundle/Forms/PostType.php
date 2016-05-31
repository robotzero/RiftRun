<?php

namespace RiftRunBundle\Forms;

use RiftRunBundle\DTO\PostDTO;
use RiftRunBundle\Model\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    /**
     * @var array
     */
    private $typesMap = [
        'rift' => RiftType::class,
        'grift' => GriftType::class
    ];

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();

            //@Todo verify that type is set to allowed types.
            if (array_key_exists('type', $data['query']['game'])) {
            //if (isset($data['query']['game']['type'])) {
                $searchquery = $form->get('query');
                $searchquery->add('game', $this->typesMap[$data['query']['game']['type']], ['required' => true]);
            }
        });

        $builder->add('query', SearchQueryType::class, ['required' => true]);
        $builder->add('player', CharacterType::class, ['required' => true]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RiftRunBundle\DTO\PostDTO',
            'csrf_protection' => false,
            'cascade_validation' => true
        ));
    }

    public function getName()
    {
        return 'post';
    }
}
