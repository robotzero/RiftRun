<?php

namespace App\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\DTO\CharacterDTO;
use Symfony\Component\Validator\Constraints\Valid;

class CharacterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type', TextType::class, ['required' => true]);
        $builder->add('paragonPoints', IntegerType::class, ['required' => true]);
        $builder->add('battleTag', TextType::class, ['required' => true]);
        $builder->add('region', TextType::class, ['required' => true]);
        $builder->add('seasonal', TextType::class, ['required' => true]);
        $builder->add('gameType', TextType::class, ['required' => true]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => CharacterDTO::class,
            'constraints' => new Valid(),
            'csrf_protection' => false,
        ));
    }

    public function getName()
    {
        return 'character';
    }
}