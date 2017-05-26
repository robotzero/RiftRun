<?php

namespace App\Infrastructure\Post\Factory\Form\Event;

use App\Infrastructure\GameMode\Factory\Form\GriftType;
use App\Infrastructure\GameMode\Factory\Form\RiftType;
use JMS\Serializer\Exception\ValidationFailedException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\ConstraintViolationList;

/**
 * Class GameModeEvent
 * @package App\Infrastructure\Post\Factory\Form\Event
 */
class GameModeEvent implements EventSubscriberInterface
{
    /** @var array  */
    private $typesMap = [
        'rift' => RiftType::class,
        'grift' => GriftType::class
    ];

    /**
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents(): array
    {
        return [FormEvents::PRE_SUBMIT => 'preSubmit'];
    }

    /**
     * @param FormEvent $event
     */
    public function preSubmit(FormEvent $event): void
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (isset($data['query']['game']['gameMode'])) {
            if (array_key_exists($data['query']['game']['gameMode'], $this->typesMap)) {
                $searchquery = $form->get('query');
                $searchquery->add('game', $this->typesMap[$data['query']['game']['gameMode']], ['mapped' => false]);
                //unset($data['query']['game']['gameMode']);
            } else {
                //$searchquery->add('game', RiftType::class, ['mapped' => false]);
                //throw new ValidationFailedException(new ConstraintViolationList());
            }
        };
    }
}