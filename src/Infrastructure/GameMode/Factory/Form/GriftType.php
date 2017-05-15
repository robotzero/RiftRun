<?php

namespace App\Infrastructure\GameMode\Factory\Form;

use App\Domain\GameMode\Model\Grift;
use App\DTO\GriftDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

/**
 * Class GriftType
 * @package App\Infrastructure\GameMode\Factory\Form
 */
class GriftType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('level', TextType::class, ['required' => true, 'mapped' => false]);
        $builder->add('gameMode', TextType::class, [ 'required' => true, 'mapped' => false ]);
    }

    /**
     * @param OptionsResolver $resolver
     * @throws \Symfony\Component\OptionsResolver\Exception\AccessException
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Grift::class,
            'csrf_protection' => false,
            'empty_data' => function(FormInterface $form) {
                new Grift(
                    $form->get('level')->getData()
                );
            },
            'constraints' => new Valid(),
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
