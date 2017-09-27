<?php

namespace App\Domain\Post\Repository;

use App\Domain\Post\Model\Post;
use App\Domain\Post\ValueObject\PostId;
use Pagerfanta\Pagerfanta;

/**
 * Interface PostRepositoryInterface
 * @package App\Domain\Post\Repository
 */
interface PostRepositoryInterface
{
    /**
     * @param array $filters
     * @param array $operators
     * @param array $values
     * @return Pagerfanta
     */
    public function findAll(array $filters = [], array $operators = [], array $values = []) : Pagerfanta;

    /**
     * @param Post $post
     * @return Post
     */
    public function save(Post $post): Post;

    /**
     * @param PostId $uuid
     * @return Post
     */
    public function get(PostId $uuid): Post;
}