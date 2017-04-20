<?php

namespace App\Domain\Post\Repository;

use App\Model\Post;
use Pagerfanta\Pagerfanta;

/**
 * Interface PostRepositoryInterface
 * @package App\Domain\Post\Repository
 */
interface PostRepositoryInterface
{
    public function findAll() : Pagerfanta;
    public function save(Post $post): Post;
}