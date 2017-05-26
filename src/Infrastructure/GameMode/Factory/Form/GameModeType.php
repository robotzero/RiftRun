<?php

namespace App\Infrastructure\GameMode\Factory\Form;

use App\Domain\GameMode\Model\AbstractGameMode;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class GameModeType
 * @package App\Infrastructure\GameMode\Factory\Form
 */
abstract class GameModeType extends AbstractType
{
    /**
     * @param OptionsResolver $resolver
     * @throws \Symfony\Component\OptionsResolver\Exception\AccessException
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => AbstractGameMode::class,
            'csrf_protection' => false,
            'constraints' => new Valid(),
        ));
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'gamemode';
    }
}
