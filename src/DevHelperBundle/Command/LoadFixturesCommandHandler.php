<?php

namespace DevHelperBundle\Command;

use DevHelperBundle\Command\LoadFixtures;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Hautelook\AliceBundle\Alice\DataFixtureLoader;

final class LoadFixturesCommandHandler extends DataFixtureLoader
{
    private $entityManager = null;
    private $fixtures = null;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    protected function getFixtures()
    {
        if ($this->fixtures === null) {
            throw new \Exception();
        }

        return $this->fixtures;
    }

    public function handle(LoadFixtures $loadFixtures)
    {
        $this->fixtures = $loadFixtures->fixtures();
        return $this->load($this->entityManager);
    }
}
