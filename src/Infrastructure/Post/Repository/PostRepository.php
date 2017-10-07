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
     * @param array $filters
     * @param array $operators
     * @param array $values
     * @return Pagerfanta
     * @throws \App\Infrastructure\Common\Exception\Doctrine\ORM\CriteriaOperatorException
     */
    public function findAll(array $filters = [], array $operators = [], array $values = []) : Pagerfanta {
        $queryBuilder = $this->createQueryBuilder('posts');
        $queryBuilder->select('posts')
            ->innerJoin('posts.query', 'query')
            ->innerJoin('posts.player', 'player')
            ->innerJoin('query.gameMode', 'game')
            ->innerJoin('query.playerCharacters', 'playerchars')
            ->orderBy('posts.createdAt', 'desc')
            ->add('where', ['posts.createdAt > :createdAt'])
            ->setParameter('createdAt', new \DateTime('-111 month'), Type::DATETIME);

        return $this->createOperatorPaginator($queryBuilder, $filters, $operators, $values);
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
     * @throws \App\Domain\Post\Exception\PostNotFoundException
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