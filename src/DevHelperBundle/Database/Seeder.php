<?php

namespace DevHelperBundle\Database;

use DevHelperBundle\Command\AliceFixtureLoader;
use Doctrine\ORM\EntityManagerInterface;

class Seeder
{
    private $aliceFixtureLoader;
    private $doctrineManager;

    public function __construct(
        AliceFixtureLoader $aliceFixtureLoader,
        EntityManagerInterface $doctrineManager
    ) {
        $this->aliceFixtureLoader = $aliceFixtureLoader;
        $this->doctrineManager = $doctrineManager;
    }

    public function loadFixtures(array $fileLocations)
    {
        $this->aliceFixtureLoader->setFixtures($fileLocations);

        return $this->aliceFixtureLoader->load($this->doctrineManager);
    }
}
