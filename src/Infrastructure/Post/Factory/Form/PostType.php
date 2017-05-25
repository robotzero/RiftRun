<?php

namespace App\Infrastructure\Post\Factory\Form;

use App\Domain\Post\Model\Post;
use App\Domain\Post\ValueObject\PostId;
use App\Infrastructure\Player\Factory\Form\PlayerType;
use App\Infrastructure\Post\Factory\Form\Event\GameModeEvent;
use App\Infrastructure\SearchQuery\Factory\Form\SearchQueryType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class PostType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('query', SearchQueryType::class, ['mapped' => false]);
        $builder->add('player', PlayerType::class, ['mapped' => false]);
        $builder->addEventSubscriber(new GameModeEvent());
    }

    /**
     * @param OptionsResolver $resolver
     * @throws \Symfony\Component\OptionsResolver\Exception\AccessException
     * @throws \OutOfBoundsException
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Post::class,
            'csrf_protection' => false,
            'empty_data' => function (FormInterface $form) {
                return new Post(
                    new PostId(),
                    $form->all()['player']->getData() ?: null,
                    $form->all()['query']->getData() ?: null
                );
            },
            'constraints' => new Valid()
        ));
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'post';
    }
}
