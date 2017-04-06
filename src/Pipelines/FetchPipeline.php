<?php

namespace App\Pipelines;

use Doctrine\Common\Persistence\ManagerRegistry;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use App\ORM\Specification\Specification;

class FetchPipeline implements ServicePipeline
{
    /** @var ManagerRegistry */
    private $doctrine;

    /** @var Specification */
    private $specification;

    /** @var string $repositoryName */
    private $repositoryName;

    /**
     * FetchPipeline constructor.
     * @param ManagerRegistry $doctrine
     * @param Specification $specification
     * @param string $repositoryName
     */
    public function __construct(ManagerRegistry $doctrine, Specification $specification, string $repositoryName)
    {
        $this->doctrine = $doctrine;
        $this->specification = $specification;
        $this->repositoryName = $repositoryName;
    }

    public function __invoke():Pagerfanta
    {
        $repository = $this->doctrine->getRepository($this->repositoryName);
        $queryBuilder = $repository->match($this->specification, null);
        return new Pagerfanta(new DoctrineORMAdapter($queryBuilder));
    }
}