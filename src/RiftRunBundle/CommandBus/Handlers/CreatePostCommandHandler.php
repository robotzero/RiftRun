<?php

namespace RiftRunBundle\CommandBus\Handlers;

use Doctrine\ORM\EntityManagerInterface;
use League\Pipeline\Pipeline;
use League\Pipeline\PipelineInterface;
use RiftRunBundle\CommandBus\Commands\Create;
use RiftRunBundle\CommandBus\Pipelines\ProcessFormPipe;
use RiftRunBundle\CommandBus\Pipelines\TransformDTOPipe;

final class CreatePostCommandHandler implements CommandHandler
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var PipelineInterface */
    private $pipeline;

    /** @var ProcessFormPipe */
    private $processFormPipe;

    /** @var TransformDTOPipe */
    private $transformDTOPipe;

    public function __construct(
        EntityManagerInterface $entityManager,
        PipelineInterface $pipeline,
        ProcessFormPipe $processFormPipe,
        TransformDTOPipe $transformDTOPipe
    ) {
        $this->entityManager = $entityManager;
        $this->pipeline = $pipeline;
        $this->processFormPipe = $processFormPipe;
        $this->transformDTOPipe = $transformDTOPipe;
    }

    public function handle(Create $createPost)
    {
        $pipeline = $this->pipeline->pipe($this->processFormPipe)->pipe($this->transformDTOPipe);
        $post = $pipeline->process($createPost);

        try {
            $this->entityManager->persist($post);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        return $post;
    }
}
