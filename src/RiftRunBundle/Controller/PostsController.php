<?php

namespace RiftRunBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Options;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use RiftRunBundle\CommandBus\Commands\CreatePost;
use RiftRunBundle\CommandBus\Commands\FetchSingle;
use RiftRunBundle\CommandBus\Commands\PagerfantaPaginate;
use RiftRunBundle\CommandBus\Commands\ProcessPostForm;
use RiftRunBundle\ORM\Specification\AllPostsSpecification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostsController extends FOSRestController
{
    /**
     * @param Request $request
     * @return Response
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
     * @return Post
     * @View()
     * @Get("/posts/{id}")
     */
    public function getPostAction(Request $request, $id)
    {
        $queryService = $this->container->get('fetch_post_service');
        return new Response($this->container->get('serializer')->serialize($queryService->query('Post', $id), 'json'));
    }

    /**
     * @return array
     * @View()
     * @Post("/posts")
     */
    public function createPostAction(Request $request)
    {
        $commandBus = $this->container->get('tactician.commandbus.default');

        $post = $commandBus->handle(new CreatePost(
            'RiftRunBundle\Forms\PostType',
            $request->getMethod(),
            $request->request->all()
        ));

        return new Response(json_encode(['postId' => $post->getId(), 'searchQueryId' => $post->getQuery()->getId()]), 201);
    }

    /**
     * @return array
     * @View()
     * @Options("/posts")
     */
    public function optionsPostsAction(Request $request) {
        $response = new Response();
        $response->headers->set('Access-Control-Allow-Headers', 'Origin, Access-Control-Allow-Origin, Key, X-Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
        $response->headers->set('Access-Control-Allow-Origin', 'http://fa.local');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
        return $response;
    }
}
