<?php
namespace DevHelperBundle\Factories;

use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;
use Nelmio\Alice\Persister\Doctrine;

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
        return new Fixtures(new Doctrine($this->entityManager));
    }
}