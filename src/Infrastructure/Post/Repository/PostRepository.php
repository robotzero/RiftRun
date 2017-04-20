<?php

namespace App\Infrastructure\Post\Repository;

use App\Domain\Post\Repository\PostRepositoryInterface;
use App\Model\Post;
use Doctrine\DBAL\Types\Type;
use App\Infrastructure\Common\Doctrine\ORM\EntityRepository;
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
//            ->innerJoin('posts.query', 'q')
//            ->innerJoin('posts.player', 'p')
//            ->innerJoin('q.game', 'g')
//            ->innerJoin('q.characterType', 'ct')
            ->orderBy('posts.createdAt', 'desc')
            ->add('where', ['posts.createdAt > :createdAt'])
            ->setParameter('createdAt', new \DateTime('-1 month'), Type::DATETIME);

        return $this->getPaginator($queryBuilder);
    }

    public function save(Post $post): Post
    {
        $this->getEntityManager()->persist($post);
        $this->getEntityManager()->flush();
        return $post;
    }
}