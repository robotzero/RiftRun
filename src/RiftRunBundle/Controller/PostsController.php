<?php

namespace RiftRunBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Options;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use RiftRunBundle\CommandBus\Commands\CreatePost;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use RiftRunBundle\Forms\PostType;

class PostsController extends FOSRestController
{
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
        $queryService = $this->container->get('fetch_posts_service');
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
        $queryService = $this->container->get('fetch_post_service');
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
