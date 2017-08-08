<?php

namespace App\Infrastructure\Player\Factory\Form;

use App\Domain\Player\Model\Player;
use App\Domain\Player\ValueObject\PlayerId;
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
        $builder->add('type', TextType::class, ['mapped' => false]);
        $builder->add('paragonPoints', IntegerType::class, ['mapped' => false]);
        $builder->add('battleTag', TextType::class, ['mapped' => false]);
        $builder->add('region', TextType::class, ['mapped' => false]);
        $builder->add('seasonal', IntegerType::class, ['mapped' => false]);
        $builder->add('gameType', TextType::class, ['mapped' => false]);
    }

    /**
     * @param OptionsResolver $resolver
     * @throws \Symfony\Component\OptionsResolver\Exception\AccessException
     * @throws \OutOfBoundsException
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Player::class,
            'constraints' => new Valid(),
            'csrf_protection' => false,
            'empty_data' => function (FormInterface $form) {
                $playerData = $form->all();
                return new Player(
                    new PlayerId(),
                    $playerData['type']->getData() ?: '',
                    $playerData['paragonPoints']->getData() ?: 0,
                    $playerData['battleTag']->getData() ?: '',
                    $playerData['region']->getData() ?: '',
                    $playerData['seasonal']->getData() ?: 0,
                    $playerData['gameType']->getData() ?: '',
                    new \DateTime()
                );
            }
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
