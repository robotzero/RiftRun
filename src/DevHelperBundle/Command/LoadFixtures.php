<?php

namespace DevHelperBundle\Command;

final class LoadFixtures
{
    private $fixturesToLoad;

    public function __construct(array $fixtures)
    {
        $this->fixturesToLoad = $fixtures;
    }

    public function fixtures()
    {
        return $this->fixturesToLoad;
    }
}
