<?php

namespace App\Infrastructure\Player\Factory;

use App\Domain\Player\Model\Player;
use App\Infrastructure\Common\Factory\AbstractFormFactory;
use App\Infrastructure\Player\Factory\Form\PlayerType;
use Symfony\Component\Form\FormFactory;

class PlayerFormFactory extends AbstractFormFactory
{
    public function __construct(FormFactory $factory)
    {
        $this->formClass = PlayerType::class;
        parent::__construct($factory);
    }

    /**
     * @param array $data
     * @return Player
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     * @throws \Symfony\Component\Form\Exception\AlreadySubmittedException
     * @throws \App\Infrastructure\Common\Exception\Form\FormException
     */
    public function create(array $data): Player
    {
        return $this->execute(self::CREATE, $data);
    }
}