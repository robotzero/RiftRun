<?php
namespace DevHelperBundle\Factories;

use Fidry\AliceDataFixtures\LoaderInterface;

final class AliceLoaderFactory implements LoaderFactory
{
    /**
     * @var LoaderInterface
     */
    private $loader;

    public function __construct(LoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    public function getLoader():LoaderInterface
    {
        return $this->loader;
    }
}