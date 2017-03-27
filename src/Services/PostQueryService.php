<?php

namespace App\Services;

use App\DTO\PostDTO;
use App\Model\Post;
use App\Transformers\EntityToDTOTransformer;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * @param string $id
     * @return PostDTO
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function query(string $id):PostDTO
    {
        $repository = $this->doctrine->getRepository('RiftRunners:Post');
        $post = $repository->findOneBy(['id' => $id]);
        if ($post instanceof Post) {
            $transformer = new EntityToDTOTransformer();
            return $transformer->transform($post);
        }
        throw new NotFoundHttpException('Post not found.');
    }
}