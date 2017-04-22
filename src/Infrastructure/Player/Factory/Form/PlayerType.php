<?php

namespace App\Infrastructure\Player\Factory\Form;

use App\Domain\Player\Model\Player;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

/**
 * Class PlayerType
 * @package App\Infrastructure\Player\Factory\Form
 */
class PlayerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('type', TextType::class, ['required' => true]);
        $builder->add('paragonPoints', IntegerType::class, ['required' => true]);
        $builder->add('battleTag', TextType::class, ['required' => true]);
        $builder->add('region', TextType::class, ['required' => true]);
        $builder->add('seasonal', TextType::class, ['required' => true]);
        $builder->add('gameType', TextType::class, ['required' => true]);
    }

    /**
     * @param OptionsResolver $resolver
     * @throws \Symfony\Component\OptionsResolver\Exception\AccessException
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Player::class,
//            'constraints' => new Valid(),
            'csrf_protection' => false,
//            'empty_data' => function (FormInterface $form) {
//                return new Player(
////                    $form->getData()->get('uuid') ?: new PostId()
//                    new Player(),
//
//                );
//            }
        ));
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'player';
    }
}
