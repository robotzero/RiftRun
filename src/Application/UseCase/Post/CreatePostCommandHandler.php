<?php

namespace App\Application\UseCase\Post;

use App\Application\Common\CommandHandler;
use App\Application\Common\Request\Create;
use App\Domain\Post\Repository\PostRepositoryInterface;
use App\Infrastructure\Post\Factory\PostFormFactory;
use Symfony\Component\Form\FormFactoryInterface;

final class CreatePostCommandHandler implements CommandHandler
{
    /** @var PostRepositoryInterface */
    private $postRepository;

    /** @var FormFactoryInterface  */
    private $formFactory;

    public function __construct(
        PostRepositoryInterface $postRepository,
        PostFormFactory $formFactory
    ) {
        $this->postRepository = $postRepository;
        $this->formFactory = $formFactory;
    }

    public function handle(Create $createPost)
    {
        $post = $this->formFactory->create($createPost->getRequestData());
        try {
            $this->postRepository->save($post);
        } catch (\Exception $e) {
            error_log($e->getMessage());
        }
//        $pipelineBuilder = (new PipelineBuilder)
//            ->add(new ProcessFormPipe($this->formFactory))
//            ->add(new TransformDTOPipe());
//
//        /** @var Pipeline $pipeline */
//        $pipeline = $pipelineBuilder->build();
//
//        $post = $pipeline->process($createPost);
//        $this->entityManager->persist($post);
//
//        /** @TODO change return value to event dispatch */
        return $post;
    }
}
