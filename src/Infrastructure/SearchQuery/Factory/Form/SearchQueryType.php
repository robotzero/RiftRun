<?php

namespace App\Infrastructure\SearchQuery\Factory\Form;

use App\Domain\GameMode\Model\Rift;
use App\Domain\SearchQuery\Model\SearchQuery;
use App\Domain\SearchQuery\ValueObject\SearchQueryId;
use App\Infrastructure\GameMode\Factory\Form\GameModeType;
use Doctrine\Common\Util\Debug;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

/**
 * Class SearchQueryType
 * @package App\Infrastructure\SearchQuery\Factory\Form
 */
class SearchQueryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
//        $builder->add(
//            'characterType',
//            CollectionType::class,
//            [
//                'entry_type' => CharacterTypeType::class,
//                'allow_add' => true,
//                'required' => true,
//                'by_reference' => false,
//                'allow_delete' => false
//            ]
//        );
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
                $queryData = $form->all();
                return new SearchQuery(
                    new SearchQueryId(),
                    new Rift($queryData['game']->get('torment')->getData()),
                    $queryData['minParagon']->getData()
                );
            }
//            'constraints' => new Valid(),
        ));
    }

    public function getName()
    {
        return 'query';
    }
}
