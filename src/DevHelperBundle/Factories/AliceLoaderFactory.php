<?php
namespace DevHelperBundle\Factories;

use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Loader\NativeLoader;

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
     * @return NativeLoader
     */
    public function getLoader():NativeLoader
    {
        return new NativeLoader();
        // return new Fixtures(new Doctrine($this->entityManager));
    }

    public function getEntityManager():ObjectManager
    {
        return $this->entityManager;
    }
}