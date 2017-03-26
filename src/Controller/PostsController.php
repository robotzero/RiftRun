<?php

namespace App\Controller;

use App\Services\PostQueryService;
use App\Services\PostsQueryService;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Options;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use App\CommandBus\Commands\CreatePost;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Forms\PostType;

class PostsController extends FOSRestController
{
    private $postsQueryService;
    private $postQueryService;
    private $commandBus;

//    public function __construct(
//        PostsQueryService $postsQueryService,
//        PostQueryService $postQueryService,
//        CommandBus $commandBus
//    ) {
//        $this->postsQueryService = $postsQueryService;
//        $this->postQueryService = $postQueryService;
//        $this->commandBus = $commandBus;
//    }

    /**
     * @param Request $request
     * @return Response
     * @throws \InvalidArgumentException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException
     * @View()
     * @Get("/posts")
     */
    public function getPostsAction(Request $request)
    {
        $queryService = $this->container->get(PostsQueryService::class);
        return $queryService->query($request->get('page', 1), $request->get('limit', 20), $request->get('_route'));
    }

    /**
     * @param $id
     * @return Response
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException
     * @throws \InvalidArgumentException
     * @View()
     * @Get("/posts/{id}")
     */
    public function getPostAction($id)
    {
        $queryService = $this->container->get(PostQueryService::class);
        return new Response($this->container->get('serializer')->serialize($queryService->query('Post', $id), 'json'));
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
        $commandBus = $this->container->get('tactician.commandbus.default');

        $post = $commandBus->handle(new CreatePost(
            PostType::class,
            $request->getMethod(),
            $request->request->all()
        ));

        return new Response(json_encode(['postId' => $post->getId(), 'searchQueryId' => $post->getQuery()->getId()]), 201);
    }
}
