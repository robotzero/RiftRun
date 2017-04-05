<?php

namespace App\Forms;

use App\DTO\SearchQueryDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class SearchQueryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'characterType',
            CollectionType::class,
            [
                'entry_type' => CharacterTypeType::class,
                'allow_add' => true,
                'required' => true,
                'by_reference' => false,
                'allow_delete' => false
            ]
        );
        $builder->add('minParagon', IntegerType::class, ['required' => true]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => SearchQueryDTO::class,
            'csrf_protection' => false,
            'constraints' => new Valid(),
        ));
    }

    public function getName()
    {
        return 'searchquery';
    }
}