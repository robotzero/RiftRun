<?php

namespace App\Infrastructure\Post\Factory\Form;

use App\Domain\GameMode\Model\AbstractGameMode;
use App\Domain\GameMode\Model\Rift;
use App\Domain\Player\Model\Player;
use App\Domain\Player\ValueObject\PlayerId;
use App\Domain\Post\Model\Post;
use App\Domain\Post\ValueObject\PostId;
use App\Domain\SearchQuery\Model\SearchQuery;
use App\Domain\SearchQuery\ValueObject\SearchQueryId;
use App\DTO\PostDTO;
use App\Infrastructure\GameMode\Factory\Form\GriftType;
use App\Infrastructure\GameMode\Factory\Form\RiftType;
use App\Infrastructure\Player\Factory\Form\PlayerType;
use App\Infrastructure\SearchQuery\Factory\Form\SearchQueryType;
use Doctrine\Common\Util\Debug;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class PostType extends AbstractType
{
    /**
     * @var array
     */
    private $typesMap = [
        'rift' => RiftType::class,
        'grift' => GriftType::class
    ];

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();

//            @Todo verify that type is set to allowed types.
            if (isset($data['query']['game']['gameMode'])) {
                $searchquery = $form->get('query');
                $searchquery->add('game', $this->typesMap[$data['query']['game']['gameMode']], ['mapped' => false]);
                unset($data['query']['game']['gameMode']);
            }
        });
        $builder->add('query', SearchQueryType::class, ['mapped' => false]);
        $builder->add('player', PlayerType::class, ['mapped' => false]);
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
                    $form->all()['player']->getData(),
                    $form->all()['query']->getData()
                );
            }
//            'constraints' => new Valid(),
        ));
    }

    public function getName(): string
    {
        return 'post';
    }
}
