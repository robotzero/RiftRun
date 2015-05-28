<?php

namespace DevHelperBundle\Database;

use DevHelperBundle\Command\AliceFixtureLoader;

class Seeder
{
    private $aliceFixtureLoader;
    private $doctrineManager = null;

    public function __construct(
        AliceFixtureLoader $aliceFixtureLoader,
        $doctrineManager
    ) {
        $this->aliceFixtureLoader = $aliceFixtureLoader;
        $this->doctrineManager = $doctrineManager;
    }

    public function loadFixtures(array $fileLocations)
    {
        return $this->buildFixtures($fileLocations);
    }

    private function buildFixtures(array $fileLocations)
    {
        $loadedFixtures = [];

        if (null === $this->doctrineManager) {
            throw new \Exception();
        }

        $this->aliceFixtureLoader->setFixtures($fileLocations);

        return $this->aliceFixtureLoader->load($this->doctrineManager);
    }
}
