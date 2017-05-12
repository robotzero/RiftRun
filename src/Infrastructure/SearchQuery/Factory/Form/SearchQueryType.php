<?php

namespace App\Infrastructure\SearchQuery\Factory\Form;

use App\Domain\GameMode\Model\AbstractGameMode;
use App\Domain\SearchQuery\Model\SearchQuery;
use App\Domain\SearchQuery\ValueObject\SearchQueryId;
use App\Infrastructure\PlayerCharacter\Factory\Form\PlayerCharacterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Valid;

/**
 * Class SearchQueryType
 * @package App\Infrastructure\SearchQuery\Factory\Form
 */
class SearchQueryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'playerCharacter',
            CollectionType::class,
            [
                'entry_type' => PlayerCharacterType::class,
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => false,
                'mapped' => false
            ]
        );
        $builder->add('minParagon', IntegerType::class, ['mapped' => false]);
    }

    /**
     * @param OptionsResolver $resolver
     * @throws \Symfony\Component\OptionsResolver\Exception\AccessException
     * @throws \OutOfBoundsException
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => SearchQuery::class,
            'csrf_protection' => false,
            'empty_data' => function (FormInterface $form) {
                $playerCharacters = $form->all()['playerCharacter']->getData();
                $queryData = $form->all();
                $searchQuery = new SearchQuery(
                    new SearchQueryId(),
                    AbstractGameMode::createGameMode($queryData['game']->all()) ?: null,
                    $queryData['minParagon']->getData() ?: null
                );

                foreach ($playerCharacters as $playerCharacter) {
                    $playerCharacter->setSearchQuery($searchQuery);
                    $searchQuery->addPlayerCharacter($playerCharacter);
                }

                return $searchQuery;
            },
            'constraints' => new Valid(),
        ));
    }

    public function getName()
    {
        return 'query';
    }
}
