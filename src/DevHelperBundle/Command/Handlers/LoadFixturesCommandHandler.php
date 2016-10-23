<?php

namespace DevHelperBundle\Command\Handlers;

use DevHelperBundle\Command\Commands\LoadFixturesInterface;
use DevHelperBundle\Factories\LoaderFactory;
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
        $fixturesLoader = $this->loaderFactory->getLoader();
        $objectSet = $fixturesLoader->loadFile($fixtures[0]);

        /** @var ObjectManager */
        $entityManager = $this->loaderFactory->getEntityManager();
        try {
            $entityManager->persist($objectSet);
            $entityManager->flush();
        } catch (\Exception $e) {
            echo $e->getMessage();
            die("Error during persisting");
        }
        return $objectSet;
    }
}
