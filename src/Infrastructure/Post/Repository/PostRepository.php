<?php

namespace App\Infrastructure\Post\Repository;

use App\Domain\Post\Exception\PostNotFoundException;
use App\Domain\Post\Model\Post;
use App\Domain\Post\Repository\PostRepositoryInterface;
use App\Domain\Post\ValueObject\PostId;
use Doctrine\DBAL\Types\Type;
use App\Infrastructure\Common\Doctrine\ORM\EntityRepository;
use Pagerfanta\Pagerfanta;

/**
 * Class PostRepository
 * @package App\Infrastructure\Post
 */
class PostRepository extends EntityRepository implements PostRepositoryInterface
{
    /**
     * @return Pagerfanta
     */
    public function findAll() : Pagerfanta {
        $queryBuilder = $this->createQueryBuilder($alias = 'posts');
        $queryBuilder->select('posts')
            ->innerJoin('posts.query', 'q')
            ->innerJoin('posts.player', 'p')
            ->innerJoin('q.gameMode', 'g')
            ->innerJoin('q.playerCharacters', 'qp')
            ->orderBy('posts.createdAt', 'desc')
            ->add('where', ['posts.createdAt > :createdAt'])
            ->setParameter('createdAt', new \DateTime('-1 month'), Type::DATETIME);

        return $this->getPaginator($queryBuilder);
    }

    /**
     * @param Post $post
     * @return Post
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \Doctrine\ORM\ORMException
     */
    public function save(Post $post): Post
    {
        $this->getEntityManager()->persist($post);
        return $post;
    }

    /**
     * @param PostId $uuid
     * @return Post
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws PostNotFoundException
     */
    public function get(PostId $uuid): Post
    {
        $post = $this->findOneById($uuid);

        if (!$post) {
            throw new PostNotFoundException();
        }

        return $post;
    }

    /**
     * @param PostId $uuid
     * @return Post|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    private function findOneById(PostId $uuid): ?Post
    {
        return $this->createQueryBuilder('post')
            ->where('post.id = :id')
            ->setParameter('id', $uuid->bytes())
            ->getQuery()
            ->getOneOrNullResult();
    }
}