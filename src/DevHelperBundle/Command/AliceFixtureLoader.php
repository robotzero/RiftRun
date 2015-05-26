<?php

namespace DevHelperBundle\Command;

use Hautelook\AliceBundle\Alice\DataFixtureLoader;

class AliceFixtureLoader extends DataFixtureLoader
{
    private $fixtures = null;

    public function setFixtures(array $fixtures)
    {
        $this->fixtures = $fixtures;
    }
    protected function getFixtures()
    {
        if ($this->fixtures === null) {
            throw new \Exception();
        }

        return $this->fixtures;
    }
}
