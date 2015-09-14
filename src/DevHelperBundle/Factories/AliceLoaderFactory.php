<?php
namespace DevHelperBundle\Factories;

use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;

final class AliceLoaderFactory implements LoaderFactory
{
    /**
     * @var ObjectManager
     */
    private $entityManager;

    public function __construct(ObjectManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return \Nelmio\Alice\Fixtures
     */
    public function getLoader()
    {
        return new Fixtures($this->entityManager);
    }
}