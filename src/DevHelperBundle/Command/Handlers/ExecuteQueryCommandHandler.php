<?php

namespace DevHelperBundle\Command\Handlers;

use DevHelperBundle\Command\Commands\ExecuteQueryInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

final class ExecuteQueryCommandHandler
{
    /** @var RegistryInterface */
    private $doctrine;

    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param ExecuteQueryInterface $clearDatabaseQuery
     */
    public function handle(ExecuteQueryInterface $clearDatabaseQuery)
    {
        $specification = $clearDatabaseQuery->getSpecification();
        $repository = $this->doctrine->getRepository('RiftRunners:Post');

        $queryBuilder = $repository->match($specification, null);
        $results = $queryBuilder->getQuery()->execute();
        $manager = $this->doctrine->getManagerForClass('RiftRunBundle\Model\Post');
        foreach ($results as $result) {
            $manager->merge($result);
            $manager->refresh($result);
            $manager->remove($result);
        }
        $manager->flush();
    }
}