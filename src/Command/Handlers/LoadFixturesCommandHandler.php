<?php

namespace App\Command\Handlers;

use App\Command\Commands\LoadFixturesInterface;
use App\Factories\LoaderFactory;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;

final class LoadFixturesCommandHandler
{
    /**
     * @var LoaderFactory
     */
    private $loaderFactory;

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

        /** @var ObjectManager */
        $loader = $this->loaderFactory->getLoader();
        try {
            $objectSet = $loader->load($fixtures);
        } catch (\Exception $e) {
            echo $e->getMessage();
            die('Error during persisting');
        }
        return $objectSet;
    }
}
