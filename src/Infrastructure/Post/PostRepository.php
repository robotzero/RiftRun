<?php

namespace App\Infrastructure\Post;

use App\Domain\Post\Repository\PostRepositoryInterface;
use Infrastructure\Common\Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository implements PostRepositoryInterface
{

}