<?php

namespace RiftRunBundle\CommandBus\Handlers;

use Doctrine\ORM\EntityManagerInterface;
use League\Pipeline\Pipeline;
use RiftRunBundle\CommandBus\Commands\Create;
use RiftRunBundle\CommandBus\Pipelines\PipelineManagerInterface;
use Symfony\Component\Form\FormFactory;

final class CreatePostCommandHandler implements CommandHandler
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var  PipelineManagerInterface */
    private $pipelineManager;

    public function __construct(
        EntityManagerInterface $entityManager,
        PipelineManagerInterface $pipelineManager
    ) {
        $this->entityManager = $entityManager;
        $this->pipelineManager = $pipelineManager;
    }

    public function handle(Create $createPost)
    {
        /** @var Pipeline $pipeline */
        $pipeline = $this->pipelineManager->build(['processFormPipe' => 'form.factory', 'transformDTOPipe' => null]);
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
