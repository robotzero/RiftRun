<?php

namespace RiftRunBundle\CommandBus\Handlers;

use Doctrine\ORM\EntityManagerInterface;
use RiftRunBundle\CommandBus\Commands\Create;

final class CreatePostCommandHandler implements CommandHandler
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var CommandHandler */
    private $processForm;

    /** @var  CommandHandler */
    private $transformDTO;

    public function __construct(
        EntityManagerInterface $entityManager,
        CommandHandler $processForm,
        CommandHandler $transformDTO
    ) {
        $this->entityManager = $entityManager;
        $this->processForm = $processForm;
        $this->transformDTO = $transformDTO;
    }

    public function handle(Create $createPost)
    {
        $dto = $this->processForm->handle($createPost);
        $post = $this->transformDTO->handle($dto);

        try {
            $this->entityManager->persist($post);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        
        return $post;
    }
}
