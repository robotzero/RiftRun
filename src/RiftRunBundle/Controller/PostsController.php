<?php

namespace RiftRunBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use RiftRunBundle\CommandBus\Commands\CreatePost;
use RiftRunBundle\Forms\PostType;
use RiftRunBundle\Model\Post as PostModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PostsController extends FOSRestController
{
    /**
     * @return array
     * @View()
     * @Get("/posts")
     */
    public function getPostsAction(Request $request)
    {
        return $this->container->get('paginationfactory')->create(
            'post',
            'get_posts'
        );
    }

    /**
     * @return Post
     * @View()
     * @Get("/posts/{id}")
     */
    public function getPostAction(Request $request, $id)
    {
        return $this->container->get('singletype_factory')->create($id, 'post');
    }

    /**
     * @return array
     * @View()
     * @Post("/posts")
     */
    public function createPostAction(Request $request)
    {
        $commandBus = $this->container->get('tactician.commandbus.default');
        return $commandBus->handle(new CreatePost());
    }
}
