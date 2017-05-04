<?php

namespace App\Infrastructure\GameMode\Factory\Form;

use App\Domain\GameMode\Model\Rift;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class RiftType
 * @package App\Infrastructure\GameMode\Factory\Form
 */
class RiftType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('torment', NumberType::class, ['mapped' => false]);
        $builder->add('gameMode', TextType::class, [ 'mapped' => false ]);
    }

    /**
     * @param OptionsResolver $resolver
     * @throws \Symfony\Component\OptionsResolver\Exception\AccessException
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Rift::class,
//            'constraints' => new Valid(),
            'csrf_protection' => false,
            'empty_data' => function(FormInterface $form) {
                new Rift(
                    $form->get('torment')->getData()
                );
            }
        ));
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'rift';
    }
}