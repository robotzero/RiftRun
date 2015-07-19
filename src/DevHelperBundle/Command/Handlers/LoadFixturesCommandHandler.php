<?php

namespace DevHelperBundle\Command\Handlers;

use DevHelperBundle\Command\Commands\LoadFixturesInterface;
use DevHelperBundle\Command\LoadFixtures;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Hautelook\AliceBundle\Alice\DataFixtureLoader;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

final class LoadFixturesCommandHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager = null;

    /**
     * @var null
     */
    private $fixtures = null;

    public function __construct(ObjectManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // /**
    //  * @return array
    //  */
    // protected function getFixtures()
    // {
    //     if ($this->fixtures === null) {
    //         throw new InvalidArgumentException("Wrong fixtures!");
    //     }

    //     return $this->fixtures;
    // }

    /**
     * Loads fixtures into the sql lite database
     * @param  LoadFixtures $loadFixtures Command
     * @return ArrayCollection
     */
    public function handle(LoadFixturesInterface $loadFixtures)
    {
        $this->fixtures = $loadFixtures->fixtures();

        $objects = \Nelmio\Alice\Fixtures::load($this->fixtures, $this->entityManager);

        return $objects;
    }
}
