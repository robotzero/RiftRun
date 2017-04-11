<?php

namespace App\Infrastructure\Post;

use App\Domain\Post\Repository\PostRepositoryInterface;
use Doctrine\DBAL\Types\Type;
use Infrastructure\Common\Doctrine\ORM\EntityRepository;
use Pagerfanta\Pagerfanta;

/**
 * Class PostRepository
 * @package App\Infrastructure\Post
 */
class PostRepository extends EntityRepository implements PostRepositoryInterface
{
    public function findAll() : Pagerfanta {
        $queryBuilder = $this->createQueryBuilder($alias = 'posts');
        $queryBuilder->select('posts')
            ->innerJoin('posts.query', 'q')
            ->innerJoin('posts.player', 'p')
            ->innerJoin('q.game', 'g')
            ->innerJoin('q.characterType', 'ct')
            ->orderBy('posts.createdAt', 'desc')
            ->add('where', ['posts.createdAt > :createdAt'])
            ->setParameter('createdAt', new \DateTime('-1 month'), Type::DATETIME);

        return $this->getPaginator($queryBuilder);
    }
}