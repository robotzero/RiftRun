<?php

namespace RiftRunBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PostsController extends Controller
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
    // public function getPostAction(Request $request, $id)
    // {
    //     return $this->container->get('singletype_factory')->create($id, 'post');
    // }
}
