<?php

namespace App\CommandBus\Handlers;

use Doctrine\ORM\EntityManagerInterface;
use League\Pipeline\Pipeline;
use League\Pipeline\PipelineBuilder;
use App\CommandBus\Commands\Create;
use App\CommandBus\Pipelines\ProcessFormPipe;
use App\CommandBus\Pipelines\TransformDTOPipe;
use Symfony\Component\Form\FormFactoryInterface;

final class CreatePostCommandHandler implements CommandHandler
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var FormFactoryInterface  */
    private $formFactory;

    public function __construct(
        EntityManagerInterface $entityManager,
        FormFactoryInterface $formFactory
    ) {
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
    }

    public function handle(Create $createPost)
    {
        $pipelineBuilder = (new PipelineBuilder)
            ->add(new ProcessFormPipe($this->formFactory))
            ->add(new TransformDTOPipe());

        /** @var Pipeline $pipeline */
        $pipeline = $pipelineBuilder->build();

        $post = $pipeline->process($createPost);
        $this->entityManager->persist($post);

        /** @TODO change return value to event dispatch */
        return $post;
    }
}