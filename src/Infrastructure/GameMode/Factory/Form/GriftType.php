<?php

namespace App\Infrastructure\GameMode\Factory\Form;

use App\Domain\GameMode\Model\Grift;
use App\Domain\GameMode\ValueObject\GameModeId;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

/**
 * Class GriftType
 * @package App\Infrastructure\Player\Factory\Form
 */
class GriftType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('level', TextType::class, ['mapped' => false]);
        $builder->add('gameMode', TextType::class, ['mapped' => false]);
    }

    /**
     * @param OptionsResolver $resolver
     * @throws \Symfony\Component\OptionsResolver\Exception\AccessException
     * @throws \OutOfBoundsException
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Grift::class,
            'constraints' => new Valid(),
            'csrf_protection' => false,
            'empty_data' => function (FormInterface $form) {
                $playerData = $form->all();
                return new Grift(
                    new GameModeId(),
                    $playerData['level']->getData() ?: ''
                );
            }
        ));
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'grift';
    }
}
