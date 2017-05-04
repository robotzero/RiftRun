<?php

namespace App\Infrastructure\PlayerCharacter\Factory\Form;

use App\Domain\PlayerCharacter\Model\PlayerCharacter;
use App\Domain\PlayerCharacter\ValueObject\PlayerCharacterId;
use App\DTO\CharacterTypeDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

/**
 * Class PlayerCharacterType
 * @package App\Infrastructure\PlayerCharacter\Factory\Form
 */
class PlayerCharacterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('type', TextType::class, ['mapped' => false]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => PlayerCharacter::class,
            'empty_data' => function (FormInterface $form) {
                return new PlayerCharacter($form->get('type')->getData());
            },
//            'empty_data' => function (FormInterface $form) {
//                $characterTypeDTO = new CharacterTypeDTO();
//                $characterTypeDTO->type = $form->get('type')->getData();
//                return $characterTypeDTO;
//                return new ModelCharacterType(
//                    $form->get('type')->getData()
//                );
//            },
            'csrf_protection' => false,
//            'constraints' => new Valid(),
        ));
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'charactertype';
    }
}
