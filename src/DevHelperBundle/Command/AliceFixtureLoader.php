<?php

namespace DevHelperBundle\Command;

use Hautelook\AliceBundle\Alice\DataFixtureLoader;

class AliceFixtureLoader extends DataFixtureLoader
{
    protected function getFixtures()
    {
        $rootDir = $this->container->getParameter('kernel.root_dir');

        return ['riftrun' => $rootDir . '/../test/Fixtures/DatabaseSeeder/wizards.yml'];
    }
}
