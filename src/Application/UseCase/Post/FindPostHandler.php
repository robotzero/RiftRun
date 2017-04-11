<?php

namespace App\Application\UseCase\Post;

use App\Application\Request\Common\Pagination;
use App\Domain\Post\Repository\PostRepositoryInterface;
use Pagerfanta\Pagerfanta;

/**
 * Class FindPostHandler
 * @package App\Application\UseCase\Post
 */
class FindPostHandler
{
    /**
     * @var PostRepositoryInterface
     */
    private $repository;

    /**
     * FindPostHandler constructor.
     * @param PostRepositoryInterface $repository
     */
    public function __construct(PostRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Pagination $request
     * @return Pagerfanta
     */
    public function handle(Pagination $request): Pagerfanta
    {
//        return null;
        return $this->repository->findAll();
    }
}