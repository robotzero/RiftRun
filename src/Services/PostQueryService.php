<?php

namespace App\Services;

use App\DTO\PostDTO;
use App\Pipelines\TransformEntity;
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
     * @return PostDTO
     * @TODO return Not Found when post is not found.
     */
    public function query(string $repositoryName, string $id):PostDTO
    {
        $repository = $this->doctrine->getRepository('RiftRunners:' . $repositoryName);
        $post = $repository->findOneBy(['id' => $id]);
        $transform = new TransformEntity();
        return $transform->transform($post);
    }
}