<?php

namespace App\Services;

use App\DTO\PostDTO;
use App\Model\Post;
use App\Transformers\EntityToDTOTransformer;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostQueryService implements QueryService
{
    /** @var ManagerRegistry */
    private $doctrine;

    /**
     * PostQueryService constructor.
     * @param ManagerRegistry $doctrine
     */
    public function __construct(ManagerRegistry $doctrine)
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