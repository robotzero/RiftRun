<?php

namespace App\Command\Commands;

final class LoadFixtures implements LoadFixturesInterface
{
    /**
     * List of fixtures to load.
     * @var array
     */
    private $fixturesToLoad;

    public function __construct(array $fixtures)
    {
        $this->fixturesToLoad = $fixtures;
    }

    /**
     * @return array
     */
    public function fixtures()
    {
        return $this->fixturesToLoad;
    }
}
