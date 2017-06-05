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
    public function findAll() : Pagerfanta;
    public function save(Post $post): Post;
    public function get(PostId $uuid): Post;
}