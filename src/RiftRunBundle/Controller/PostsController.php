<?php

namespace RiftRunBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Options;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use RiftRunBundle\CommandBus\Commands\FetchSingle;
use RiftRunBundle\CommandBus\Commands\PagerfantaPaginate;
use RiftRunBundle\CommandBus\Commands\ProcessPostForm;
use RiftRunBundle\ORM\Specification\AllPostsSpecification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostsController extends FOSRestController
{
    /**
     * @return array
     * @View()
     * @Get("/posts")
     */
    public function getPostsAction(Request $request)
    {
        $commandBus = $this->container->get('tactician.commandbus.default');
        $collection = $commandBus->handle(new PagerfantaPaginate(
                new AllPostsSpecification(),
                null,
                $request->get('page', 1),
                $request->get('limit', 20),
                'Post',
                $request->get('_route'))
        );

        return new Response($this->container->get('serializer')->serialize($collection, 'json'));
    }

    /**
     * @return Post
     * @View()
     * @Get("/posts/{id}")
     */
    public function getPostAction(Request $request, $id)
    {
        $commandBus = $this->container->get('tactician.commandbus.default');
        return new Response($this->container->get('serializer')->serialize($commandBus->handle(new FetchSingle($id, 'Post')), 'json'));
    }

    /**
     * @return array
     * @View()
     * @Post("/posts")
     */
    public function createPostAction(Request $request)
    {
        $commandBus = $this->container->get('tactician.commandbus.default');

        $commandBus->handle(new ProcessPostForm(
            $request,
            'RiftRunBundle\Forms\PostType',
            $request->getMethod(),
            $request->request->all()
        ));
        //@TODO return proper id of created object.
        return new Response(json_encode(['id' => 0]), 201);
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
