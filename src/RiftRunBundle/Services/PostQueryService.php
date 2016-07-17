<?php

namespace RiftRunBundle\Services;

use Symfony\Bridge\Doctrine\RegistryInterface;

class PostQueryService implements QueryService
{
    /** @var  RegistryInterface */
    private $doctrine;

    /**
     * PostQueryService constructor.
     * @param RegistryInterface $doctrine
     */
    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param string $repositoryName
     * @param string $id
     * @return Object
     * @TODO change to DTO object instead model.
     * @TODO return Not Found when post is not found.
     */
    public function query(string $repositoryName, string $id):Object
    {
        $repository = $this->doctrine->getRepository('RiftRunners:' . $repositoryName);
        return $repository->findOneBy(['id' => $id]);
    }
}