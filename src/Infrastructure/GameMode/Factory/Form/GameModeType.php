<?php

namespace App\Infrastructure\GameMode\Factory\Form;

use App\Domain\GameMode\Model\GameMode;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

/**
 * Class GameModeType
 * @package App\Infrastructure\GameMode\Factory\Form
 */
class GameModeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('gameMode', TextType::class, [ 'mapped' => false ]);
        $builder->add('torment', TextType::class, [ 'mapped' => false ]);
    }

    /**
     * @param OptionsResolver $resolver
     * @throws \Symfony\Component\OptionsResolver\Exception\AccessException
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => GameMode::class,
            'empty_data' => function(FormInterface $form) {
                return new GameMode(
                    $form->get('gameMode')->getData() ?: ''
                );
            },
            'csrf_protection' => false,
            'constraints' => new Valid(),
        ));
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'gamemode';
    }
}
