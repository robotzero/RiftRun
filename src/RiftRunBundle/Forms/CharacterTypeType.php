<?php

namespace RiftRunBundle\Forms;

use RiftRunBundle\DTO\CharacterTypeDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use RiftRunBundle\Model\CharacterType as ModelCharacterType;
use Symfony\Component\Validator\Constraints\Valid;

class CharacterTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type', TextType::class, ['required' => true]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => CharacterTypeDTO::class,
//            'empty_data' => function (FormInterface $form) {
//                $characterTypeDTO = new CharacterTypeDTO();
//                $characterTypeDTO->type = $form->get('type')->getData();
//                return $characterTypeDTO;
//                return new ModelCharacterType(
//                    $form->get('type')->getData()
//                );
//            },
            'csrf_protection' => false,
            'constraints' => new Valid(),
        ));
    }

    public function getName()
    {
        return 'charactertype';
    }
}
