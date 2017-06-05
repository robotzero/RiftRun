<?php

namespace App\Application\UseCase\Post;

use App\Application\UseCase\Post\Request\GetPost;
use App\Domain\Post\Model\Post;
use App\Domain\Post\Repository\PostRepositoryInterface;

/**
 * Class GetPostHandler
 * @package App\Application\UseCase\Post
 */
final class GetPostHandler
{
    /** @var PostRepositoryInterface */
    private $repository;

    /**
     * GetPostHandler constructor.
     * @param PostRepositoryInterface $repository
     */
    public function __construct(PostRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param GetPost $request
     * @return Post
     */
    public function handle(GetPost $request): Post
    {
        return $this->repository->get($request->getUuid());
    }
}