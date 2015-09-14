<?php

namespace DevHelperBundle\Command\Handlers;

use DevHelperBundle\Command\Commands\LoadFixturesInterface;
use DevHelperBundle\Factories\LoaderFactory;
use Doctrine\Common\Collections\ArrayCollection;
use Nelmio\Alice\Fixtures;

final class LoadFixturesCommandHandler
{
    /**
     * @var LoaderFactory
     */
    private $loaderFactory = null;

    /**
     * @var null
     */
    private $fixtures = null;

    public function __construct(LoaderFactory $loaderFactory)
    {
        $this->loaderFactory = $loaderFactory;
    }

    /**
     * Loads fixtures into the sql lite database
     * @param  LoadFixturesInterface $loadFixtures Command
     * @return ArrayCollection
     */
    public function handle(LoadFixturesInterface $loadFixtures)
    {
        $fixtures = $loadFixtures->fixtures();

        $fixturesLoader = $this->loaderFactory->getLoader();
        $objects = $fixturesLoader->loadFiles($fixtures);

        return $objects;
    }
}
