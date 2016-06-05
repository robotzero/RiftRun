<?php

namespace RiftRunBundle\CommandBus\Handlers;

use Doctrine\ORM\EntityManagerInterface;
use League\Pipeline\Pipeline;
use League\Pipeline\PipelineInterface;
use RiftRunBundle\CommandBus\Commands\Create;
use RiftRunBundle\CommandBus\Pipelines\ProcessFormPipe;

final class CreatePostCommandHandler implements CommandHandler
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var  CommandHandler */
    private $transformDTO;

    /** @var PipelineInterface */
    private $pipeline;

    /** @var ProcessFormPipe */
    private $processFormPipe;

    public function __construct(
        EntityManagerInterface $entityManager,
        CommandHandler $transformDTO,
        PipelineInterface $pipeline,
        ProcessFormPipe $processFormPipe
    ) {
        $this->entityManager = $entityManager;
        $this->transformDTO = $transformDTO;
        $this->pipeline = $pipeline;
        $this->processFormPipe = $processFormPipe;
    }

    public function handle(Create $createPost)
    {
        $pipeline = $this->pipeline->pipe($this->processFormPipe);
        $dto = $pipeline->process($createPost);
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
