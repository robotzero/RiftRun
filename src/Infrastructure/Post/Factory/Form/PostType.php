<?php

namespace App\Infrastructure\Post\Factory\Form;

use App\Domain\Player\Model\Player;
use App\Domain\Player\ValueObject\PlayerId;
use App\Domain\Post\Model\Post;
use App\Domain\Post\ValueObject\PostId;
use App\DTO\PostDTO;
use App\Infrastructure\Player\Factory\Form\PlayerType;
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

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
//            $data = $event->getData();
//            $form = $event->getForm();

            //@Todo verify that type is set to allowed types.
//            if (isset($data['query']['game']['type'])) {
//                $searchquery = $form->get('query');
//                $searchquery->add('game', $this->typesMap[$data['query']['game']['type']], ['required' => true]);
//            }
//        });
        $builder->add('uuid', null, ['mapped' => false]);
//        $builder->add('query', SearchQueryType::class, ['required' => true]);
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
                $playerData = $form->get('player');
                return new Post(
                    new PostId(),
                    new Player(
                        new PlayerId(),
                        $playerData->get('type')->getData(),
                        $playerData->get('paragonPoints')->getData(),
                        $playerData->get('battleTag')->getData(),
                        $playerData->get('region')->getData(),
                        $playerData->get('seasonal')->getData(),
                        $playerData->get('gameType')->getData(),
                        new \DateTime()
                    )
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
