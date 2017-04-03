<?php

namespace App\Controller;

use App\Services\PostQueryService;
use App\Services\PostsQueryService;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Options;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use App\CommandBus\Commands\CreatePost;
use FOS\RestBundle\Request\ParamFetcherInterface;
use JMS\Serializer\SerializerInterface;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Forms\PostType;

class PostsController
{
    private $postsQueryService;
    private $postQueryService;
    private $commandBus;
    private $serializer;

    public function __construct(
        PostsQueryService $postsQueryService,
        PostQueryService $postQueryService,
        CommandBus $commandBus,
        SerializerInterface $serializer
    ) {
        $this->postsQueryService = $postsQueryService;
        $this->postQueryService = $postQueryService;
        $this->commandBus = $commandBus;
        $this->serializer = $serializer;
    }

    /**
     * @param Request $request
     * @param ParamFetcherInterface $paramFetcher
     * @return Response
     * @throws \InvalidArgumentException
     * @View()
     * @QueryParam(name="page", key="page", requirements="\d+", default=1, description="", strict=true, nullable=true)
     * @QueryParam(name="limit", key="limit", requirements="\d+", default=20, description="", strict=true, nullable=true)
     * @Get("/posts")
     */
    public function getPostsAction(Request $request, ParamFetcherInterface $paramFetcher):Response
    {
        return $this->postsQueryService->query($paramFetcher->get('page', true), $paramFetcher->get('limit', true), $request->get('_route'));
    }

    /**
     * @param $id
     * @return Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException
     * @throws \InvalidArgumentException
     * @View()
     * @Get("/posts/{id}")
     */
    public function getPostAction($id)
    {
        return new Response($this->serializer->serialize($this->postQueryService->query($id), 'json'));
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \InvalidArgumentException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException
     * @View()
     * @Post("/posts")
     */
    public function createPostAction(Request $request)
    {
        $post = $this->commandBus->handle(new CreatePost(
            PostType::class,
            $request->getMethod(),
            $request->request->all()
        ));

        return new Response(json_encode(['postId' => $post->getId(), 'searchQueryId' => $post->getQuery()->getId()]), 201);
    }
}
