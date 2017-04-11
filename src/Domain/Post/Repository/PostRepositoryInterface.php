<?php

namespace App\Domain\Post\Repository;

use Pagerfanta\Pagerfanta;

/**
 * Interface PostRepositoryInterface
 * @package App\Domain\Post\Repository
 */
interface PostRepositoryInterface
{
    public function findAll() : Pagerfanta;
}