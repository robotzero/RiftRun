<?php

namespace RiftRunBundle\CommandBus\Handlers;

use Doctrine\ORM\EntityManagerInterface;
use RiftRunBundle\CommandBus\Commands\Create;

final class CreatePostCommandHandler
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function handle(Create $createPost)
    {
        $post = $createPost->getPost();
        try {
            $this->entityManager->persist($post);
            $this->entityManager->flush($post);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
